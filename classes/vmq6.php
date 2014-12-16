<?

class vmq6 {
  
  var $Contacts = null;
  var $Emails = null;
  var $Config = null;
  var $Db;                                                                                             
  
  
  function vmq6($pDb) {
 
    if($this->InitDb($pDb)) {
      $this->Contacts = new vmq6contacts($pDb);
      $this->Emails = new vmq6emails($pDb);
      $this->Config = new vmq6config($pDb);
     
      
    } else {
      return false;
    }
  }
  
  
  function Status() {
    return "Everything is fine!";
  }
  
  function Queue() {
    return $this->Emails->ListQueued();
    
    
  }
    
  
  function CheckEmail($pEmail) {
    return true;
  }
  
  
  function OptimizeContent($pContent) {
    return $pContent;
  }
    
  
  function InitDb($pDb) {

    if($pDb->Connect()) {
      $this->Db = $pDb;
      return true;
    } else {
      return false;
    }
  }  
                           
  
  function Send($pId,$pBaseDir="") {
    if(intval($pId)>0) {
       $this->Emails->LoadFromId($pId);
       $my_id =$pId;
    } else {
      $my_id = $this->Emails->NextInQueue();
      $this->Emails->LoadFromId($my_id);
    }
  
    $this->Emails->PrepareContent($this->Emails->GetParam(VMQ6_EMAILS_MESSAGE),$pBaseDir);
    
    $this->Emails->Send($my_id);
    
  
  }  
    
    
    
    
      
}

?>