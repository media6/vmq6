<?
/*
Usage example :
  $t= new swqUtilisateur($active_db);
  $t->CreerUtilisateur(1,'wz');

Comment créer une nouvelle classe:
1- remplacer le mot gin_options par votre nouveau nom d'objet
2- remplacer le mot gin_options par le nom de la table
2- remplacer le mot gcoContact par le nom de la classe

*/
  
  
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("VMQ6_CONTACTS_DB_VERSION",        '1.0.2');
  define("VMQ6_CONTACTS_DB_TABLE",          'vmq6_contacts');
  
   define("VMQ6_CONTACTS_STATUS_ACTIVE",    0);
   define("VMQ6_CONTACTS_STATUS_ERROR",    1);
   define("VMQ6_CONTACTS_STATUS_INACTIVE",    2);    
 
  $id_const = 1000;
  define("VMQ6_CONTACTS_ID",              $id_const++);  
  define("VMQ6_CONTACTS_NOM",     $id_const++);
  define("VMQ6_CONTACTS_PRENOM",     $id_const++);
  define("VMQ6_CONTACTS_STATUS",     $id_const++);    
  define("VMQ6_CONTACTS_COURRIEL",     $id_const++);
  define("VMQ6_CONTACTS_DATEINSCRIT",     $id_const++); 
  define("VMQ6_CONTACTS_DATEMODIF",     $id_const++);
  
  //** COSTUM FIELDS
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class vmq6contacts extends iptDbObject {

  var $hts_title   = "Options";
  var $hts_db_table   = VMQ6_CONTACTS_DB_TABLE;
  var $hts_db_version = VMQ6_CONTACTS_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( VMQ6_CONTACTS_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      VMQ6_CONTACTS_NOM            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_CONTACTS_PRENOM            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_CONTACTS_STATUS            => IPT_FIELD_TYPE_INT,
                                      VMQ6_CONTACTS_COURRIEL            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_CONTACTS_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME,
                                      VMQ6_CONTACTS_DATEMODIF           => IPT_FIELD_TYPE_DATETIME);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (VMQ6_CONTACTS_ID            => 'id',
                                      VMQ6_CONTACTS_NOM            => 'tnom',
                                      VMQ6_CONTACTS_PRENOM            => 'tprenom',
                                      VMQ6_CONTACTS_STATUS            => 'istatus',
                                      VMQ6_CONTACTS_COURRIEL            => 'tcourriel',
                                      VMQ6_CONTACTS_DATEINSCRIT  => 'dinscrit',
                                      VMQ6_CONTACTS_DATEMODIF  => 'dmodif');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       

  var $Parent = null;
   

   
  function InfosContacts($pId,$pDefaultValues=true) {                          
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, '' tnom, '' ttitre, ''  dinscrit,0 kcms_album ";
               
              } else {
              
                $query="select * 
                           from vmq6_contacts
                           where id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
  
  function ListeContacts() {
     $reqListe = "select vmq6_contacts.*
                  
            from    vmq6_contacts
            
            order by vmq6_contacts.tcourriel asc
            ";
            
           $rs = new iptDBQuery;
        				$rs->Open($reqListe,$this->hts_db);
                           
              return $rs;    
   
  }
      
  
 
 
 
  function ComboContacts() {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select 0 id, 'Veuillez choisir une option' tnom, ''  dinscrit
                         union
                         select vmq6_contacts.id, vmq6_contacts.tcourriel tnom, '2' dinscrit
                         from vmq6_contacts
                         order by 3 asc,2 asc",$this->hts_db);
             
              return $rs;

  
  }



  function Check($pAddress,$pLastName="",$pFirstName="") {
  
    $pValid = true;
    
    
    $pAddress = trim(strtolower($pAddress));
    
    $z = new iptEmail();
    if($z->CheckAddress($pAddress)) {
    
              $rs = new iptDBQuery;
      				$rs->Open("select vmq6_contacts.*
                         from vmq6_contacts
                        where tcourriel = '".addslashes($pAddress)."'",$this->hts_db);
             
              $id = 0;
              $bSave = true;
              
              if($rs->RowCount()>0) {
              
                $id = $rs->GetValue("id",0);
                if($rs->GetValue("tnom",0)==$pLastName && $rs->GetValue("tprenom",0)==$pFirstName ) {
                    $bSave=false;
                }
                
              }
              
              if($bSave) {
                $this->LoadFromId($id);
                $this->SetParam(VMQ6_CONTACTS_COURRIEL,$pAddress);
                $this->SetParam(VMQ6_CONTACTS_NOM,$pLastName);
                $this->SetParam(VMQ6_CONTACTS_PRENOM,$pFirstName);
                $id = $this->Save();
              }
              $pValid= $id;
    
    } else {
      //invalid char in email
      $pValid=false;
    }

      
    
  
    return $pValid;


  }    

  function Infos($pId) {
     $reqListe = "select vmq6_contacts.*,
        case  vmq6_contacts.istatus when 0 then 'Active' when 1 then 'Error' when 2 then 'Inactive' end tstatus
                       
                  
                  
                   
            from    vmq6_contacts
         where  vmq6_contacts.id=".intval($pId)."
            ";
            
           $rs = new iptDBQuery;
        				$rs->Open($reqListe,$this->hts_db);
            //   print $reqListe;            
              return $rs;    
   
  }
  
  function ListEmails($pId) {
     $reqListe = "select v2.tnom,v2.tprenom,v2.tcourriel,
                          case  vmq6_routing.istatus when 0 then 'Queued' when 1 then 'Sent' when 2 then 'Error' end tstatus,
                          vmq6_emails.* 
                         from vmq6_routing
                          left outer join vmq6_emails on vmq6_emails.id=vmq6_routing.kvmq6_email
                         left outer join vmq6_contacts v2 on v2.id=vmq6_emails.kvmq6_contact
                         where vmq6_routing.kvmq6_contact=".intval($pId)."
                         order by vmq6_routing.dinscrit desc
                         limit 10
            ";
            
           $rs = new iptDBQuery;
        				$rs->Open($reqListe,$this->hts_db);
                           
              return $rs;    
   
  }
  
  
  function Event_Save_Before($pId) {
  
    if($this->GetParam(VMQ6_CONTACTS_DATEINSCRIT)=="") {
      $this->SetParam(VMQ6_CONTACTS_DATEINSCRIT,date('YmdHis'));
    }
    $this->SetParam(VMQ6_CONTACTS_DATEMODIF,date('YmdHis'));
  }
  
  function UpdateStatus($pEmail,$pStatus) {
  
         $reqListe = "select *
                         from vmq6_contacts
                         
                         where tcourriel ='".addslashes($pEmail)."'
                         
            ";
            
           $rs = new iptDBQuery;
        	 $rs->Open($reqListe,$this->hts_db);
        	 if($rs->RowCount()>0) {
        	 
        	   $this->LoadFromId($rs->GetValue("id",0));
        	   $this->SetParam(VMQ6_CONTACTS_STATUS,$pStatus);
        	   $this->Save(); 
           
           }
        	 
        	 
  
  }
      
    
}



?>