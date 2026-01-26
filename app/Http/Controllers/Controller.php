<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Trả về phản hồi JSON chuẩn hóa
     *
     * @param mixed $context
     * @param int|bool $status
     * @param string|null $message
     * @return JsonResponse
     * @throws \Exception
     */
    public function jsonResponse($context = [], $status = 200, $message = null): JsonResponse
    {
        if ($context instanceof Model) {
            $context = $context->toArray();
        } else if ($context instanceof Validator) {
            $context = $context->errors()->toArray();
        }

        if ($status >= 500) {
            throw new \Exception($message);
        }

        return response()->json([
            'status' => ($status === true) ? 200 : (($status === false) ? 400 : $status),
            'message' => $message,
            'context' => $context
        ], ($status === true) ? 200 : (($status === false) ? 400 : $status));
    }

    /**
     * Chuyển đổi câu lệnh SQL Server sang MySQL
     *
     * @param string $sql
     * @return string
     */
    public function convertSqlServerToMySql(string $sql): string
    {
        if (preg_match('/\b(CREATE|ALTER)\s+PROCEDURE\b/i', $sql)) {
            if (preg_match('/BEGIN\s+(.*)\s+END\s*$/is', $sql, $m)) {
                $sql = $m[1];
            }
        }
        $sql = preg_replace('/\bdbo\./i', '', $sql);
        $sql = preg_replace('/\[(.*?)\]/', '`$1`', $sql);
        $sql = preg_replace("/N'((?:''|[^'])*)'/u", "'$1'", $sql);
        $sql = preg_replace('/GETDATE\s*\(\s*\)/i', 'NOW()', $sql);
        $sql = preg_replace(
            '/SET\s+@\w+\s*=\s*SCOPE_IDENTITY\s*\(\s*\)\s*;/i',
            'SET @last_id = LAST_INSERT_ID();',
            $sql
        );
        $sql = preg_replace(
            '/DECLARE\s+@\w+\s+(INT|BIGINT|FLOAT|DECIMAL|NUMERIC|VARCHAR|NVARCHAR)\s*(\(\d+\))?\s*;/i',
            '',
            $sql
        );
        $sql = preg_replace('/@\w+/i', '@last_id', $sql);
        $sql = preg_replace('/WITH\s*\(\s*UPDLOCK\s*\)/i', 'FOR UPDATE', $sql);
        $sql = preg_replace('/WITH\s*\(\s*NOLOCK\s*\)/i', '', $sql);
        $sql = preg_replace('/BEGIN\s+TRAN(SACTION)?\s*;/i', 'START TRANSACTION;', $sql);
        $sql = preg_replace('/COMMIT\s*;/i', 'COMMIT;', $sql);
        $sql = preg_replace('/ROLLBACK\s*;/i', 'ROLLBACK;', $sql);
        $sql = preg_replace('/SET\s+NOCOUNT\s+ON\s*;/i', '', $sql);
        $sql = preg_replace(
            "/RAISERROR\s*\(\s*N?'([^']*)'\s*,\s*\d+\s*,\s*\d+\s*\)\s*;/i",
            "SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '$1';",
            $sql
        );
        $sql = preg_replace(
            '/CAST\s*\(\s*([^)]+)\s+AS\s+INT\s*\)/i',
            'CAST($1 AS SIGNED)',
            $sql
        );
        $sql = preg_replace_callback(
            '/\b(INSERT\s+INTO|UPDATE|DELETE\s+FROM|FROM|JOIN)\s+([a-zA-Z_][\w]*)\b/i',
            fn ($m) => $m[1] . ' `' . $m[2] . '`',
            $sql
        );
        $sql = preg_replace('/;\s*;+/',';',$sql);

        return trim($sql);
    }



    /**
     * Parse câu lệnh INSERT SQL Server thành mảng dữ liệu
     *
     * @param string $sql
     * @return array
     */
    protected function parseInsertSql(string $sql): array
    {
        preg_match(
            '/INSERT\s+INTO\s+([^\s(]+)\s*\((.*?)\)\s*VALUES\s*\((.*)\)\s*;?/is',
            $sql,
            $m
        );
        $table = str_replace(['dbo.', '`'], '', trim($m[1]));

        $columns = array_map(
            fn($c) => trim(str_replace(['[', ']'], '', $c)),
            explode(',', $m[2])
        );

        $values = $this->parseSqlValues($m[3]);

        return compact('table', 'columns', 'values');
    }

    /**
     * Parse câu lệnh UPDATE SQL Server thành mảng dữ liệu
     *
     * @param string $sql
     * @return array
     */
    protected function parseUpdateSql(string $sql): array
    {
        /* @var string  $table
         * @var array   $columns
         * @var array   $values
         * @var string|null $whereColumn
         * @var mixed|null  $whereValue
         */
        preg_match(
            '/UPDATE\s+([^\s]+)\s+SET\s+(.*?)\s+WHERE\s+(.*)\s*;?/is',
            $sql,
            $m
        );

        /* @var string  $table
         * @var array   $columns
         * @var array   $values
         * @var string|null $whereColumn
         * @var mixed|null  $whereValue
         */
        $table = str_replace(['dbo.', '`'], '', trim($m[1]));
        preg_match_all(
            '/(\w+)\s*=\s*(N\'(?:\'\'|[^\'])*\'|\'(?:\'\'|[^\'])*\'|NULL|[0-9]+(?:\.[0-9]+)?)/ui',
            $m[2],
            $setMatches,
            PREG_SET_ORDER
        );

        $columns = [];
        $values  = [];

        foreach ($setMatches as $set) {
            $columns[] = $set[1];
            $values[]  = $this->parseSqlValues($set[2])[0];
        }
        /* @var string|null $whereColumn
         * @var mixed|null  $whereValue
         */
        preg_match(
            '/(\w+)\s*=\s*(N\'(?:\'\'|[^\'])*\'|\'(?:\'\'|[^\'])*\'|[0-9]+)/ui',
            $m[3],
            $whereMatch
        );

        $whereColumn = $whereMatch[1] ?? null;
        $whereValue  = isset($whereMatch[2]) ? $this->parseSqlValues($whereMatch[2])[0] : null;

        return compact('table', 'columns', 'values', 'whereColumn', 'whereValue');
    }

    /**
     * Phân tích chuỗi giá trị trong câu lệnh SQL thành mảng
     *
     * @param string $values
     * @return array
     */
    protected function parseSqlValues(string $values): array
    {
        $result = [];
        /* @var array $matches
         */
        preg_match_all(
            "/N'(?:''|[^'])*'|'(?:''|[^'])*'|NULL|[0-9]+(?:\.[0-9]+)?/ui",
            $values,
            $matches
        );
        /* @var string $v
         */
        foreach ($matches[0] as $v) {
            $v = trim($v);
            if (preg_match("/^N'(.*)'$/us", $v, $m)) {
                $result[] = str_replace("''", "'", $m[1]);
            } elseif (preg_match("/^'(.*)'$/us", $v, $m)) {
                $result[] = str_replace("''", "'", $m[1]);
            } elseif (strtoupper($v) === 'NULL') {
                $result[] = null;
            } else {
                $result[] = is_numeric($v) ? $v + 0 : $v;
            }
        }
        return $result;
    }
}