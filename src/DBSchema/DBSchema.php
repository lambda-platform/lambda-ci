<?php

namespace Lambda\DBSchema;


trait DBSchema
{

    public static function tables($db)
    {

        $ignore_tables = [];

        $tables_ = [];
        $views_ = [];
        $query= $db->query('SHOW FULL TABLES');


        $tables = $query->getResultArray();


        $databaseName = getenv('database.default.database', 'lambda_db');

        foreach ($tables as $t) {
            $key = "Tables_in_$databaseName";
            $tableName = $t[$key];
            if (array_search($tableName, $ignore_tables)) {
            } else {
                if ($t["Table_type"] == 'VIEW') {
                    $views_[] = $tableName;
                } else {
                    $tables_[] = $tableName;
                }
            }
        }


        return [
            'tables' => $tables_,
            'views' => $views_,
        ];
    }

    /*
     * get table Meta by table name
     * */
    public static function tableMeta($db, $table)
    {
        $data = null;
        $data = [];
        try {
            $query= $db->query("show fields from `$table`");


            $data = $query->getResultArray();

        } catch (\Exception $e) {
            echo "show fields from `$table`";
            var_dump($e);
        }
        if ($data) {
            $newData = [];
            foreach ($data as $dcolumn) {
                $newData[] = [
                    'model' => $dcolumn["Field"],
                    'title' => $dcolumn["Field"],
                    'dbType' => $dcolumn["Type"],
                    'table' => $table,
                    'key' => $dcolumn["Key"],
                    'extra' => $dcolumn["Extra"],
                ];
            }

            return $newData;
        }
        if ($data) {
            return $data;
        }
    }

    public static function getDBSchema($db)
    {
        $tables = DBSchema::tables($db);
        $dbSchema = [
            'tableList' => $tables['tables'],
            'viewList' => $tables['views'],
            'tableMeta' => [],
        ];

        foreach ($tables['tables'] as $t) {
            $dbSchema['tableMeta'][$t] = DBSchema::tableMeta($db, $t);
        }

        foreach ($tables['views'] as $t) {
            $dbSchema['tableMeta'][$t] = DBSchema::tableMeta($db, $t);
        }

        return $dbSchema;
    }
}
