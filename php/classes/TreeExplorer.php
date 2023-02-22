<?php



$_SERVER['DOCUMENT_ROOT']='/var/htdocs/wotom.net'; //Указываем корневую папку (нужно, только если работаем с консольным скриптом
require_once ($_SERVER['DOCUMENT_ROOT'].'/_lib/libObjEngine.php'); //Подключаем библиотеку для работы с БД

date_default_timezone_set("Asia/Almaty");







class TreeExplorer {
    static private $glPath = "/tmp/explorer";
    private $path = "";
    private $localPath = "";
    private $fileList = [];
    private $dirList = [];
    private $info = [];
    /*--------------------------------------------------*/
    
    public function __construct(
            $path
    ) {
        $this->localPath = $path;
        $this->path = ($path) ? self::$glPath."/".$path : self::$glPath;
        $this->info = objLoad($this->path. "/dir.info");
//        echo $this->path. "/dir.info";
        if ((isset($this->info["id"])) && (!$this->info["id"]) && ($path)){
            throw new Exception("Wrong dir");
        }
        $this->fileList = objLoad($this->path. "/filelist.info");
        $this->dirList = objLoad($this->path. "/dirlist.info");
        unset($this->fileList["#e"],$this->dirList["#e"],$this->fileList["_none_"],$this->dirList["_none_"]);
//        echo "<pre>";
//        print_r($this->fileList);
//        print_r($this->dirList);
//        echo "</pre>";
    }
    
    
    /*--------------------------------------------------*/
    
    static public function setOrg(
            $org
    ){
        self::$glPath = "/ware/{$org}/TreeExplorer/material";
    }
    
    /*--------------------------------------------------*/
    
    public function save(){
        objSave($this->path. "/dir.info", "raw", $this->info);
//        echo "<pre>";
//        print_r($this->fileList);
//        print_r($this->dirList);
//        echo "</pre>";
        if (count_u($this->fileList) > 0){
            objSave($this->path. "/filelist.info", "raw", $this->fileList);
        }
        else{
            objKill($this->path. "/filelist.info");
        }
        if (count_u($this->dirList) > 0){
            objSave($this->path. "/dirlist.info", "raw", $this->dirList);
        }
        else{
            objKill($this->path. "/dirlist.info");
        }
    }
    
    /*--------------------------------------------------*/
    
    private function generateId(){
        $rand1 = (rand() % 8900)+1000;
        $rand2 = (rand() % 8900)+1000;
        $rand3 = (rand() % 8900)+1000;
        $rand4 = (rand() % 8900)+1000;
        return  $rand1. $rand2. $rand3. $rand4;
    }

    /*--------------------------------------------------*/

    public function makeDir(
            $name
    ){  
        
        $id = $this->generateId();
        $path = "{$this->path}/{$id}/dir.info";
        if (!in_array($name, $this->dirList)){
            $obj = [
                "id" => $id,
                "name" => $name
            ];
            objSave($path, "raw", $obj);
            $this->dirList[$id] = $name;
            $this->save();
            return true;
        }
        else{
            return false;
        }
    }

    /*--------------------------------------------------*/
    
    public function deleteDir(
            $id
    ){
        if (key_exists($id, $this->dirList)){
            unset($this->dirList[$id]);
            $this->save();
            objUnlinkBranch($this->path. "/{$id}/");
            return true;
        }
        else{
            return false;
        }
    }
    
    
    /*--------------------------------------------------*/
    
    public function rename(
            $id,
            $name
    ){
        if (key_exists($id, $this->dirList)){
            $obj = objLoad("{$this->path}/{$id}/dir.info");
            $obj["name"] = $name;
            $obj["id"] = $id;
            objSave("{$this->path}/{$id}/dir.info", "raw", $obj);
            $this->dirList[$id] = $name;
            $this->save();
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    /*--------------------------------------------------*/
    
    public function createFile(
            $name,
            $params
    ){
        $id = $this->generateId();
        $path = "{$this->path}/{$id}";
        if (!in_array($name, $this->fileList)){
            $params["name"] = $name;
            objSave($path, "raw", $params);
            $this->fileList[$id] = $name;
            $this->save();
            return true;
        }
        else{
            return false;
        }
    }
    
    /*--------------------------------------------------*/
    
    public function deleteFile(
            $id
    ){
        if (key_exists($id, $this->fileList)){
            unset($this->fileList[$id]);
            $this->save();
            objKill($this->path. "/{$id}");
            return true;
        }
        else{
            return false;
        }
    }
    
    
    /*--------------------------------------------------*/
    
    public function modifyFile(
            $id,
            $params
    ){
        if (key_exists($id, $this->fileList)){
            $obj = objLoad("{$this->path}/{$id}");
            foreach($params as $key => $value){
                $obj[$key] = $value;
            }
            objSave("{$this->path}/{$id}", "raw", $obj);
            $this->fileList[$id] = $obj["name"];
            $this->save();
            return true;
        }
        else{
            return false;
        }
    }
    
    /*--------------------------------------------------*/
    
    public function getPathName(){
        $path = self::$glPath."/";
        $obj = explode("/", $this->localPath);
        $name = "";
        foreach($obj as $value){
            $path = $path. "{$value}/";
            $name .= "/". (isset(objLoad($path."dir.info")["name"]) ? objLoad($path."dir.info")["name"] : "");
        }
        return $name;
        
    }
    
    /*--------------------------------------------------*/
    
    public function getDirList(){
        return $this->dirList;
    }
    
    /*--------------------------------------------------*/
    
    public function getFileList(){
        return $this->fileList;
    }
    
    /*--------------------------------------------------*/
    
    public function getFile(
            $id
    ){
        $obj = objLoad("{$this->path}/{$id}");
        
        unset($obj["#e"]);
        return $obj;
    }
    
    /*--------------------------------------------------*/
    
    
}
