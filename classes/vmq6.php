<?

class vmq6 {
  
  var $Contacts = null;
  var $Db;                                                                                             
  
  
  function vmq6($pDb) {
 
    if($this->InitDb($pDb)) {
      $this->Contacts = new vmq6contacts($pDb);
      
      
    } else {
      return false;
    }
  }
  
  
  function Status() {
    return "Everything is fine!";
  }
  
  function Queue() {
    return "Queue is empty!";
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
    
    
    
    
    
    
      
}

?>