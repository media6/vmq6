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
  define("VMQ6_CONFIG_DB_VERSION",        '1.0.2');
  define("VMQ6_CONFIG_DB_TABLE",          'vmq6_config');
  
  

  
  $id_const = 1000;
  define("VMQ6_CONFIG_ID",              $id_const++);  
  define("VMQ6_CONFIG_TITRE",     $id_const++);
  define("VMQ6_CONFIG_VALEUR",     $id_const++);
  
  //** COSTUM FIELDS
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class vmq6config extends iptDbObject {

  var $hts_title   = "Options";
  var $hts_db_table   = VMQ6_CONFIG_DB_TABLE;
  var $hts_db_version = VMQ6_CONFIG_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( VMQ6_CONFIG_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      VMQ6_CONFIG_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_CONFIG_VALEUR            => IPT_FIELD_TYPE_TEXT);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (VMQ6_CONFIG_ID            => 'id',
                                      VMQ6_CONFIG_TITRE            => 'ttitre',
                                      VMQ6_CONFIG_VALEUR           => 'tvaleur');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function SetValue($ttitre,$tvaleur) {
  
  
              $rs = new iptDBQuery;
          		$rs->Open("select vmq6_config.*
                         from vmq6_config
                          where ttitre = '".addslashes($ttitre)."'
                        ",$this->hts_db);
              $id=0;
              if($rs->RowCount()>0) {
                $id = $rs->GetValue("id",0);
              } 
              
          
              $this->LoadFromId($id);

              $this->SetParam(VMQ6_CONFIG_TITRE,$ttitre);
              $this->SetParam(VMQ6_CONFIG_VALEUR,$tvaleur);

              $this->Save();
              return true;
     
  }




  function GetValue($ttitre) {
  
  
              $rs = new iptDBQuery;
          		$rs->Open("select vmq6_config.*
                         from vmq6_config
                          where ttitre = '".addslashes($ttitre)."'
                        ",$this->hts_db);
              
              if($rs->RowCount()>0) {
                return $rs->GetValue("tvaleur",0);
              } else {
                return false;
              } 
              
     
  }
  
}

                       

?>