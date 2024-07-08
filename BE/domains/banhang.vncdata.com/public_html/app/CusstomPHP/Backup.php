<?php
namespace App\CusstomPHP;

class Backup{
    public static function backup_mysql()
    {
        $mysqlDatabaseName = env('DB_DATABASE');
        $mysqlUserName = env('DB_USERNAME');
        $mysqlPassword = env('DB_PASSWORD');
        $mysqlHostName = env('DB_HOST');
        $mysqlExportPath = '/home/hoangdai/garlovy_hoangdai_net/public/backup/database_' . $mysqlDatabaseName . "_" . \App\CusstomPHP\Time::DatenowFILE() . '.sql';

        $command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName . ' > ' . $mysqlExportPath;
        exec($command, $output, $worked);
        $data = '';
        switch ($worked) {
            case 0:
                $data = 'Cơ sở dữ liệu <b>' . $mysqlDatabaseName . '</b> đã được sao lưu thàng công <b>' . getcwd() . '/' . $mysqlExportPath . '</b>';
                break;
            case 1:
                $data = 'There was a warning during the export of <b>' . $mysqlDatabaseName . '</b> to <b>' . getcwd() . '/' . $mysqlExportPath . '</b>';
                break;
            case 2:
                $data = 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' . $mysqlDatabaseName . '</b></td></tr><tr><td>MySQL User Name:</td><td><b>' . $mysqlUserName . '</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' . $mysqlHostName . '</b></td></tr></table>';
                break;
        }
        return $data;
    }
}