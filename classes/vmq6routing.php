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
  define("VMQ6_ROUTING_DB_VERSION",        '1.0.2');
  define("VMQ6_ROUTING_DB_TABLE",          'vmq6_routing');
  
  
  
  
  define("VMQ6_ROUTING_STATUS_QUEUED",              0);  
  define("VMQ6_ROUTING_STATUS_SENT",              1);
  define("VMQ6_ROUTING_STATUS_VERIFIED",              2);
  define("VMQ6_ROUTING_STATUS_ERROR",              3);

   define("VMQ6_ROUTING_TYPE_TO",              0);  
  define("VMQ6_ROUTING_TYPE_CC",              1);
  define("VMQ6_ROUTING_TYPE_BCC",              2);

  
  $id_const = 1000;
  define("VMQ6_ROUTING_ID",              $id_const++);  
  define("VMQ6_ROUTING_EMAIL",     $id_const++);
  define("VMQ6_ROUTING_CONTACT",     $id_const++);
  define("VMQ6_ROUTING_DATEINSCRIT",     $id_const++);
  
  define("VMQ6_ROUTING_DATEMODIF",     $id_const++);
  define("VMQ6_ROUTING_STATUS",     $id_const++);
  define("VMQ6_ROUTING_TYPE",     $id_const++);
  define("VMQ6_ROUTING_DATEENVOIE",     $id_const++);
  
  //** COSTUM FIELDS
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class vmq6routing extends iptDbObject {

  var $hts_title   = "Options";
  var $hts_db_table   = VMQ6_ROUTING_DB_TABLE;
  var $hts_db_version = VMQ6_ROUTING_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( VMQ6_ROUTING_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      VMQ6_ROUTING_EMAIL            => IPT_FIELD_TYPE_INT,
                                      VMQ6_ROUTING_CONTACT            => IPT_FIELD_TYPE_INT,
                                      VMQ6_ROUTING_TYPE            => IPT_FIELD_TYPE_INT,
                                      VMQ6_ROUTING_STATUS            => IPT_FIELD_TYPE_INT, 
                                      VMQ6_ROUTING_TYPE            => IPT_FIELD_TYPE_INT,
                                      VMQ6_ROUTING_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME,
                                      VMQ6_ROUTING_DATEMODIF           => IPT_FIELD_TYPE_DATETIME,
                                      VMQ6_ROUTING_DATEENVOIE   => IPT_FIELD_TYPE_DATETIME);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (VMQ6_ROUTING_ID            => 'id',
                                      VMQ6_ROUTING_EMAIL            => 'kvmq6_email',
                                      VMQ6_ROUTING_CONTACT           => 'kvmq6_contact',
                                      VMQ6_ROUTING_TYPE            => 'itype',
                                      VMQ6_ROUTING_STATUS            => 'istatus', 
                                      VMQ6_ROUTING_TYPE            => 'itype',
                                      VMQ6_ROUTING_DATEINSCRIT  => 'dinscrit',
                                      VMQ6_ROUTING_DATEMODIF   => 'dmodif',
                                      VMQ6_ROUTING_DATEENVOIE  => 'denvoie');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function Add($id_courriel,$id_contact,$ptype=0) {

          if("".intval($id_contact)!=$id_contact) {
            $y = new vmq6contacts($this->hts_db);
            $id_contact = $y->Check($id_contact);
          }
          
          
          if($id_contact>0 && $id_courriel>0) {
  
              $rs = new iptDBQuery;
          		$rs->Open("select vmq6_routing.*
                         from vmq6_routing
                          where kvmq6_email = ".intval($id_courriel)."
                          and kvmq6_contact = ".intval($id_contact)." 
                          and itype = ".intval($ptype)."
                          and istatus=0",$this->hts_db);
             
              if($rs->RowCount()>0) {
                return false;
              } else {
                  $this->LoadFromId(0);
                  
               
                  
                  $this->SetParam(VMQ6_ROUTING_EMAIL,$id_courriel);
                  $this->SetParam(VMQ6_ROUTING_CONTACT,$id_contact);
                  $this->SetParam(VMQ6_ROUTING_TYPE,$ptype);
                  $this->SetParam(VMQ6_ROUTING_STATUS,0);
                  $this->Save();
                  return true;
              }
        }
  
  }

   
  function Event_Save_Before($pId) {
  
    if($this->GetParam(VMQ6_ROUTING_DATEINSCRIT)=="") {
      $this->SetParam(VMQ6_ROUTING_DATEINSCRIT,date('YmdHis'));
    }
    
     $this->SetParam(VMQ6_ROUTING_DATEMODIF,date('YmdHis'));
  } 
}

                       

?>