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
  define("VMQ6_CONTACTS_DB_VERSION",        '1.0.0');
  define("VMQ6_CONTACTS_DB_TABLE",          'vmq6_contacts');
  
  
  $id_const = 1000;
  define("VMQ6_CONTACTS_ID",              $id_const++);  
  define("VMQ6_CONTACTS_NOM",     $id_const++);
  define("VMQ6_CONTACTS_PRENOM",     $id_const++);
  define("VMQ6_CONTACTS_COURRIEL",     $id_const++);
  define("VMQ6_CONTACTS_DATEINSCRIT",     $id_const++);
  
  //** COSTUM FIELDS
  define("VMQ6_CONTACTS_TITRE",             $id_const++);
 
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
                                      VMQ6_CONTACTS_COURRIEL            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_CONTACTS_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (VMQ6_CONTACTS_ID            => 'id',
                                      VMQ6_CONTACTS_NOM            => 'tnom',
                                      VMQ6_CONTACTS_PRENOM            => 'tprenom',
                                      VMQ6_CONTACTS_COURRIEL            => 'tcourriel',
                                      VMQ6_CONTACTS_DATEINSCRIT  => 'dinscrit');
 
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
    
    
    $pAddress = strtolower($pAddress);
    
    $z = new iptEmail();
    if($z->CheckAddress($pAddress)) {
    
              $rs = new iptDBQuery;
      				$rs->Open("select vmq6_contacts.*
                         from vmq6_contacts
                        where tcourriel = '".addslashes($pAddress)."'",$this->hts_db);
             
              $id = 0;
              $bSave = true;
              
              if($rs->RowCount()>0) {
                $id = $rs->GetValue(VMQ6_CONTACTS_COURRIEL,0);
                if($rs->GetValue(VMQ6_CONTACTS_NOM,0)==$pLastName && $rs->GetValue(VMQ6_CONTACTS_PRENOM,0)==$pFirstName ) {
                    $bSave=false;
                }
                
              }
              if($bSave) {
                $this->LoadFromId($id);
                $this->SetParam(VMQ6_CONTACTS_COURRIEL,$pAddress);
                $this->SetParam(VMQ6_CONTACTS_NOM,$pLastName);
                $this->SetParam(VMQ6_CONTACTS_PRENOM,$pFirstName);
                $this->Save();
              }
    
    } else {
      //invalid char in email
      $pValid=false;
    }

      
    
  
    return $pValid;


  }    
  
}



?>