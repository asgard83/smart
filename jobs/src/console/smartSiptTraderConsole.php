<?php
    error_reporting(E_ALL);
    ini_set("mssql.textlimit", "2147483647");
    ini_set("mssql.textsize", "2147483647");
    
    include '../config.php';
    include '../driver/DB.php';

    $smart = new DB();
    $smart->connect(DB_HOST_SMART, DB_USERNAME_SMART, DB_PASSWORD_SMART, DB_DATABASE_SMART);
    $iMaxTraderID = $smart->get_uraian("SELECT MAX(TRADER_ID) AS LASTID FROM TM_TRADER", "LASTID");
    $smart->close();

    $sipt = new DB();
    $sipt->connect(DB_HOST_SIPT, DB_USERNAME_SIPT, DB_PASSWORD_SIPT, DB_DATABASE_SIPT);
    $sQuery = "SELECT TOP 100 SARANA_ID AS TRADER_ID, NAMA_SARANA AS TRADER_NAME, JENIS_SARANA AS TRADER_TYPE_ID, JENIS_INDUSTRI AS TRADER_INDUSTRY, 
               NAMA_PIMPINAN AS TRADER_OWNER, NPWP AS TRADER_NPWP, ALAMAT_1 AS TRADER_ADDRESS_1, ALAMAT_2 AS TRADER_ADDRESS_2,
               TELEPON AS TRADER_PHONE, FAX AS TRADER_FAX, KOTA AS REGION_ID, PROPINSI AS PROVINCE_ID, NOMOR_IZIN AS TRADER_PERMIT, NAMA_PANGAN AS TRADER_FOOD_TYPE
               FROM M_SARANA WHERE SARANA_ID > " . $iMaxTraderID;
    if($sipt->num_row($sQuery))
    {
        $result = $sipt->result_array($sQuery);
        $sipt->close();
        $smart->connect(DB_HOST_SMART, DB_USERNAME_SMART, DB_PASSWORD_SMART, DB_DATABASE_SMART);
        foreach($result as $row)
        {
            $iTraderExisting = (int)$smart->get_uraian("SELECT COUNT(*) AS COMPUTED FROM TM_TRADER WHERE TRADER_ID = ". $row['TRADER_ID'], "COMPUTED");
            if($iTraderExisting == 0)
            {
                $smart->insert("TM_TRADER", $row);
                if($smart->affected_rows() > 0)
                {
                    $message = date("Y-m-d H:i:s") . " - " . join("|", $row) .  "Affected rows " . $smart->affected_rows() . " \n";
                }
                usleep(10000);
            }
        }
        $smart->close();
    }
    else
    {
        $message = date("Y-m-d H:i:s") . " - No Record Found \n";
        consoleLog($message);
        $sipt->close();
    }
    
    function consoleLog($messageLog)
    {
        $pathLog = '../log/';
        $pathFiles = $pathLog . 'smartSiptTraderConsole_log-'.date("Ymd");
        if(!file_exists($pathFiles))
        {
            $file = fopen($pathFiles,"w");
            fwrite($file,$messageLog);
        }
        else
        {
            $contentLog = file_get_contents($pathFiles);
            $file = fopen($pathFiles,"w");
            fwrite($file,$contentLog."\n".$messageLog);
        }
        fclose($file);
    }
	
?>