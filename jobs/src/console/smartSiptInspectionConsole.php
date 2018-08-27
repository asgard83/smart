<?php
    /**
     * Console Jobs
     * Data Trader SmartBPOM
     * resync Master Sarana di SIPT
     */
    error_reporting(E_ALL);
    ini_set("mssql.textlimit", "2147483647");
    ini_set("mssql.textsize", "2147483647");
    
    include '../config.php';
    include '../driver/DB.php';
    /***
     * Select Data Pemeriksaan
     * sipt.T_PEMERIKSAAN, sipt.T_SURAT_TUGAS, sipt.T_SURAT_TUGAS_PELAPORAN, sipt.T_PEMERIKSAAN_DISTRIBUSI
     */

    function getPemeriksaan()
    {
        $sipt = new DB();
        $sipt->connect(DB_HOST_SIPT, DB_USERNAME_SIPT, DB_PASSWORD_SIPT, DB_DATABASE_SIPT);
        $arrSiptPemeriksaan = array();
        $sQuery = "SELECT PERIKSA_ID AS INSPECTION_ID, BBPOM_ID, JENIS_SARANA_ID AS TRADER_TYPE_ID, SARANA_ID AS TRADER_ID,
                   AWAL_PERIKSA AS INSPECTION_DATE_START, AKHIR_PERIKSA AS INSPECTION_DATE_END,
                   HASIL AS INSPECTION_RESULT, HASIL_PUSAT AS INSPECTION_BPOM_RESULT, STATUS INSPECTION_STATUS 
                   FROM T_PEMERIKSAAN 
                   WHERE AWAL_PERIKSA >= dateadd(day,datediff(day,90,GETDATE()),0) 
                   AND AWAL_PERIKSA < dateadd(day,datediff(day,0,GETDATE()),0) ORDER BY PERIKSA_ID ASC";
         if($sipt->num_row($sQuery))
         {
            $resultInspection = $sipt->result_array($sQuery); 
            foreach($resultInspection as $rowInspection)
            {
                $arrSiptPemeriksaan['INSPECTION']['HEADER'][] = $rowInspection;
                $sQuerySuratTugasPelaporan = "SELECT SURAT_ID AS LETTER_ID, LAPOR_ID AS INSPECTION_ID FROM T_SURAT_TUGAS_PELAPORAN WHERE LAPOR_ID = " . $rowInspection['INSPECTION_ID'];
                if($sipt->num_row($sQuerySuratTugasPelaporan))
                {
                    $resultLetterInspection = $sipt->result_array($sQuerySuratTugasPelaporan);
                    foreach($resultLetterInspection as $rowLetterInspection)
                    {
                        $arrSiptPemeriksaan['INSPECTION']['LETTER_INSPECTION'][] = $rowLetterInspection;
                        $sQuerySuratTugas = "SELECT SURAT_ID AS LETTER_ID, NOMOR AS LETTER_NUMBER, TANGGAL AS LETTER_DATE, CREATE_DATE AS LETTER_DATE_CREATED
                                            FROM T_SURAT_TUGAS WHERE SURAT_ID = " . $rowLetterInspection['LETTER_ID'];
                        if($sipt->num_row($sQuerySuratTugas))
                        {
                            $resultLetter = $sipt->result_array($sQuerySuratTugas);
                            foreach($resultLetter as $rowLetter)
                            {
                                $arrSiptPemeriksaan['INSPECTION']['LETTER'][] = $rowLetter;
                            }
                        }
                    }
                }
                $iDistribusi = (int)$sipt->get_uraian("SELECT COUNT(*) AS COMPUTED FROM T_PEMERIKSAAN_DISTRIBUSI WHERE PERIKSA_ID = ". $rowInspection['INSPECTION_ID'], "COMPUTED");
                if($iDistribusi > 0)
                {
                    $sQueryDistribusi = "SELECT PERIKSA_ID AS INSPECTION_ID, TUJUAN_PEMERIKSAAN, ASPEK_PENILAIAN, HASIL_TEMUAN, HASIL_TEMUAN_LAIN
                                         CATATAN_HASIL_PEMERIKSAAN, HASIL_PERIKSA, KASUS_POINT_A, KASUS_POINT_B, KASUS_POINT_C, KASUS_POINT_D,
                                         KASUS_POINT_E, KASUS_POINT_F, KASUS_POINT_G, KASUS_POINT_H, KLASIFIKASI_PELANGGARAN_MAJOR,
                                         KLASIFIKASI_PELANGGARAN_MINOR, TINDAK_LANJUT_BALAI, DETAIL_TINDAK_LANJUT_BALAI, TINDAK_LANJUT_PUSAT, 
                                         DETIL_TINDAK_LANJUT_PUSAT, LAMPIRAN_MAPPING, LAMPIRAN_BAP
                                         FROM T_PEMERIKSAAN_DISTRIBUSI 
                                         WHERE PERIKSA_ID = ". $rowInspection['INSPECTION_ID'];
                    if($sipt->num_row($sQueryDistribusi))
                    {
                        $resultDistribusi = $sipt->result_array($sQueryDistribusi);
                        foreach($resultDistribusi as $rowDistribusi)
                        {
                            $arrSiptPemeriksaan['INSPECTION']['DISTRIBUTION'][] = $rowDistribusi;
                        }
                    }
                }
             }
             $sipt->close();
         }
         return $arrSiptPemeriksaan;
    }

    function extractMessage()
    {
        
        echo date("Y-m-d H:i:s") . " - Starting import ... \n";
        $message = date("Y-m-d H:i:s") . " - Starting import ... \n";
        $arrPemeriksaan = getPemeriksaan();
        if(count($arrPemeriksaan) > 0)
        {
            $smart = new DB();
            $smart->connect(DB_HOST_SMART, DB_USERNAME_SMART, DB_PASSWORD_SMART, DB_DATABASE_SMART);

            $arrInspection = $arrPemeriksaan['INSPECTION']['HEADER'];
            $arrLetter = $arrPemeriksaan['INSPECTION']['LETTER'];
            $arrLetterInspection = $arrPemeriksaan['INSPECTION']['LETTER_INSPECTION'];
            
            $first = FALSE;
            $second = FALSE;
            $third = FALSE;

            $lengthArrInspection = count($arrInspection);
            if($lengthArrInspection > 0)
            {
                $firstStep = 0;
                for($a = 0; $a < $lengthArrInspection; $a++)
                {
                    $smart->insert("TM_INSPECTION", $arrInspection[$a]);
                    if($smart->affected_rows() > 0)
                    {
                        $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrInspection[$a]) .  ", Affected rows " . $smart->affected_rows() . " \n";
                    }
                    else
                    {
                        $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrInspection[$a]) .  ", Error inserting \n";
                    }
                    echo date("Y-m-d H:i:s") . " - " . join("|", $arrInspection[$a]) . " \n";
                    usleep(1000);
                    $firstStep++;
                }
                if($lengthArrInspection == $firstStep)
                {
                    $first = TRUE;
                }
            }

            if($first)
            {
                $lengthArrLetter = count($arrLetter);
                if($lengthArrLetter > 0)
                {
                    $secondStep = 0;
                    for($b = 0; $b < $lengthArrLetter; $b++)
                    {
                        $smart->insert("TM_LETTER", $arrLetter[$b]);
                        if($smart->affected_rows() > 0)
                        {
                            $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrLetter[$b]) .  ", Affected rows " . $smart->affected_rows() . " \n";
                        }
                        else
                        {
                            $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrLetter[$b]) .  ", Error inserting \n";
                        }
                        echo date("Y-m-d H:i:s") . " - " . join("|", $arrLetter[$b]) .  " \n";
                        usleep(1000);
                        $secondStep++;
                    }
                    if($lengthArrLetter == $secondStep)
                    {
                        $second = TRUE;
                    }
                }
            }
            
            if($second)
            {
                $lengthArrLetterInspection = count($arrLetterInspection);
                if($lengthArrLetterInspection > 0)
                {
                    $thirdStep = 0;
                    for($c = 0; $c < $lengthArrLetterInspection; $c++)
                    {
                        $smart->insert("TM_LETTER_INSPECTION", $arrLetterInspection[$c]);
                        if($smart->affected_rows() > 0)
                        {
                            $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrLetterInspection[$c]) .  ", Affected rows " . $smart->affected_rows() . " \n";
                        }
                        else
                        {
                            $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrLetterInspection[$c]) .  ", Error inserting \n";
                        }
                        echo date("Y-m-d H:i:s") . " - " . join("|", $arrLetterInspection[$c]) .  " \n";
                        usleep(1000);
                        $thirdStep++;
                    }
                    if($lengthArrLetterInspection == $thirdStep)
                    {
                        $third = TRUE;
                    }
                }
            }
            if($third)
            {
                if(array_key_exists('DISTRIBUTION', $arrPemeriksaan['INSPECTION']))
                {
                    $arrDistribution = $arrPemeriksaan['INSPECTION']['DISTRIBUTION'];            
                    $lengthArrDistribution = count($arrDistribution);
                    if($lengthArrDistribution > 0)
                    {
                        for($d = 0; $d < $lengthArrDistribution; $d++)
                        {
                            $smart->insert("TM_INSPECTION_DISTRIBUTION", $arrDistribution[$d]);
                            if($smart->affected_rows() > 0)
                            {
                                $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrDistribution[$d]) .  ", Affected rows " . $smart->affected_rows() . " \n";
                            }
                            else
                            {
                                $message .= date("Y-m-d H:i:s") . " - " . join("|", $arrDistribution[$d]) .  ", Error inserting \n";
                            }
                            echo date("Y-m-d H:i:s") . " - " . join("|", $arrDistribution[$d]) .  " \n";
                            usleep(1000);
                        }
                    }
                }   
            }
        }
        else
        {
            $message .= date("Y-m-d H:i:s") . " - No Record Found \n";
        }
        $message .= date("Y-m-d H:i:s") . " - End import ... \n";
        consoleLog($message);
        $smart->close();
        echo date("Y-m-d H:i:s") . " - End import ... \n";
    }
     
    function consoleLog($messageLog)
    {
        $pathLog = '../log/';
        $pathFiles = $pathLog . 'smartSiptInspectionConsole_log-'.date("YmdHis");
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

    print (extractMessage());

?>