
<?php
	if(isset($_POST['functionname']))
    {

        $paPDO = initDB();
        $paSRID = '4326';
        $paPoint = $_POST['paPoint'];
        $functionname = $_POST['functionname'];
        
        $aResult = "null";
        if ($functionname == 'getGeoCMRToAjax')
            $aResult = getGeoCMRToAjax($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfoCMRToAjax')
            $aResult = getInfoCMRToAjax($paPDO, $paSRID, $paPoint);
        
        echo $aResult;
  
        closeDB($paPDO);
    }
     function initDB()
    {
        // Kết nối CSDL
        $paPDO = new PDO('pgsql:host=localhost;dbname=SimpleClimate;port=5432', 'postgres', 'anhtu123');
        return $paPDO;
    }
    function query($paPDO, $paSQLStr)
    {
        try
        {
            // Khai báo exception
            $paPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Sử đụng Prepare 
            $stmt = $paPDO->prepare($paSQLStr);
            // Thực thi câu truy vấn
            $stmt->execute();
            
            // Khai báo fetch kiểu mảng kết hợp
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            // Lấy danh sách kết quả
            $paResult = $stmt->fetchAll();   
            return $paResult;                 
        }
        catch(PDOException $e) {
            echo "Thất bại, Lỗi: " . $e->getMessage();
            return null;
        }       
    }
    function closeDB($paPDO)
    {
        // Ngắt kết nối
        $paPDO = null;
    }
     function getGeoCMRToAjax($paPDO,$paSRID,$paPoint)
    {

        $paPoint = $_POST['paPoint'];
        //echo $paPoint;
        $paPoint = str_replace(',', ' ', $paPoint);
        //$strDistance = "ST_Distance('".$paPoint."',ST_AsText(geom))";
       // $strMinDistance = "SELECT min(ST_Distance('".$paPoint."',ST_AsText(geom))) from cmr_roads";
        $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from public.gadm36_vnm_1 
                    where ST_Within('".$paPoint."',ST_AsText(geom))";

        $result = query($paPDO, $mySQLStr);
        if ($result != null)
        {
            // Lặp kết quả
            foreach ($result as $item){
                return $item['geo'];
            }
        }
        else
            return "null";
    }
    function getInfoCMRToAjax($paPDO,$paPoint)
    {
        $paPoint = $_POST['paPoint'];
        //echo $paPoint;
        //echo "<br>";
         $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        //echo "<br>";
       // $strDistance = "ST_Distance('".$paPoint."',ST_AsText(geom))";
       // $strMinDistance = "SELECT min(ST_Distance('".$paPoint."',ST_AsText(geom))) from cmr_roads";
        $mySQLStr = "SELECT gid_1,name_1, ST_Area(geom) as geo from public.gadm36_vnm_1 
                    where ST_Within('".$paPoint."',ST_AsText(geom))";

        //echo "<br><br>";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            $resFin = '<table>';
            // Lặp kết quả
            foreach ($result as $item){
                $resFin = $resFin.'<tr><td>Mã vung: '.$item['gid_1'].'</td></tr>';
                $resFin = $resFin.'<tr><td>Ten vung: '.$item['name_1'].'</td></tr>';
                $resFin = $resFin.'<tr><td>DienTich: '.$item['geo'].'</td></tr>';
                break;
            }
            $resFin = $resFin.'</table>';
            return $resFin;
        }
        else
            return "null";
        alert($result);
    }
?>