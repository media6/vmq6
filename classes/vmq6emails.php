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
  define("VMQ6_EMAILS_DB_VERSION",        '1.0.4');
  define("VMQ6_EMAILS_DB_TABLE",          'vmq6_emails');
  
  
  define("VMQ6_EMAILS_STATUS_NEW",     0);
  define("VMQ6_EMAILS_STATUS_PROCESSING",     1);
  define("VMQ6_EMAILS_STATUS_COMPLETED",     2);
  define("VMQ6_EMAILS_STATUS_SUSPENDED",     3);
  define("VMQ6_EMAILS_STATUS_CANCELED",     9);
  
  
  
  $id_const = 1000;
  define("VMQ6_EMAILS_ID",              $id_const++);  
  
  define("VMQ6_EMAILS_FROM",     $id_const++);
  define("VMQ6_EMAILS_TITRE",     $id_const++);
  define("VMQ6_EMAILS_STATUS",     $id_const++);
  define("VMQ6_EMAILS_MESSAGE",     $id_const++);
  define("VMQ6_EMAILS_TXT",     $id_const++);
  define("VMQ6_EMAILS_HEADERS",     $id_const++);  
  define("VMQ6_EMAILS_DATEINSCRIT",     $id_const++);
  define("VMQ6_EMAILS_DEBUT",     $id_const++);
  define("VMQ6_EMAILS_FIN",     $id_const++);
  
  //** COSTUM FIELDS
  
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class vmq6emails extends iptDbObject {

  var $hts_title   = "Options";
  var $hts_db_table   = VMQ6_EMAILS_DB_TABLE;
  var $hts_db_version = VMQ6_EMAILS_DB_VERSION;


//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( VMQ6_EMAILS_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      VMQ6_EMAILS_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      VMQ6_EMAILS_FROM       => IPT_FIELD_TYPE_INT,
                                      VMQ6_EMAILS_STATUS       => IPT_FIELD_TYPE_INT,
                                      VMQ6_EMAILS_MESSAGE            => IPT_FIELD_TYPE_MULTILINE,
                                      VMQ6_EMAILS_TXT            => IPT_FIELD_TYPE_MULTILINE,
                                      VMQ6_EMAILS_HEADERS            => IPT_FIELD_TYPE_MULTILINE,
                                      VMQ6_EMAILS_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME,
                                      VMQ6_EMAILS_DEBUT            => IPT_FIELD_TYPE_DATETIME,
                                      VMQ6_EMAILS_FIN            => IPT_FIELD_TYPE_DATETIME);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (VMQ6_EMAILS_ID            => 'id',
                                      VMQ6_EMAILS_TITRE            => 'ttitre',
                                      VMQ6_EMAILS_FROM       => 'kvmq6_contact',
                                      VMQ6_EMAILS_STATUS    => 'istatus',
                                      VMQ6_EMAILS_MESSAGE            => 'lmessage',
                                      VMQ6_EMAILS_TXT            => 'ltxt',
                                      VMQ6_EMAILS_HEADERS            => 'lheaders',
                                      VMQ6_EMAILS_DATEINSCRIT  => 'dinscrit',
                                      VMQ6_EMAILS_DEBUT  => 'ddebut',
                                      VMQ6_EMAILS_FIN  => 'dfin');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       

  var $Mailer = null;

  var $Content = "";
  var $Attachments = null;   

   
  function InfosEmails($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, '' tnom, '' ttitre, ''  dinscrit,0 kcms_album ";
               
              } else {
              
                $query="select * 
                           from vmq6_emails
                           where id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
  
  function ListeEmails() {
     $reqListe = "select vmq6_emails.*
                  
            from    vmq6_emails
            
            order by vmq6_emails.dinscrit asc
            ";
            
           $rs = new iptDBQuery;
        				$rs->Open($reqListe,$this->hts_db);
                           
              return $rs;    
   
  }
      
 
  function ListQueued() {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select vmq6_emails.*,vmq6_contacts.tnom,vmq6_contacts.tprenom,vmq6_contacts.tcourriel, 
                          (select count(vmq6_routing.id) from vmq6_routing where   vmq6_routing.kvmq6_email =   vmq6_emails.id and vmq6_routing.istatus=0) nb,
                          (select count(vmq6_routing.id) from vmq6_routing where   vmq6_routing.kvmq6_email =   vmq6_emails.id and vmq6_routing.istatus<>0) nb_done,
                          (select count(vmq6_routing.id) from vmq6_routing where   vmq6_routing.kvmq6_email =   vmq6_emails.id ) nb_tot,
                          case  vmq6_emails.istatus when 0 then 'New' when 1 then 'Processing' when 2 then 'Done' when 3 then 'Suspended' when 9 then 'Cancelled' end tstatus 
                         from vmq6_emails
                         left outer join vmq6_contacts on vmq6_contacts.id=vmq6_emails.kvmq6_contact
                         
                         ",$this->hts_db);
             
              return $rs;

  
  }
  
 
 
  function Infos($pId) {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select vmq6_emails.*,vmq6_contacts.tnom,vmq6_contacts.tprenom,vmq6_contacts.tcourriel, 
                          (select count(vmq6_routing.id) from vmq6_routing where   vmq6_routing.kvmq6_email =   vmq6_emails.id and vmq6_routing.istatus=0) nb,
                          (select count(vmq6_routing.id) from vmq6_routing where   vmq6_routing.kvmq6_email =   vmq6_emails.id ) nb_tot,
                          case  vmq6_emails.istatus when 0 then 'New' when 1 then 'Processing' when 2 then 'Done' when 3 then 'Suspended' when 9 then 'Cancelled' end tstatus 
                         from vmq6_emails
                         left outer join vmq6_contacts on vmq6_contacts.id=vmq6_emails.kvmq6_contact
                         where vmq6_emails.id=".intval($pId)."",$this->hts_db);
             
              return $rs;

  
  }
 
 
  function ComboEmails() {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select 0 id, 'Veuillez choisir une option' tnom, ''  dinscrit
                         union
                         select vmq6_emails.id, vmq6_emails.ttitre tnom, '2' dinscrit
                         from vmq6_emails
                         order by 3 asc,2 asc",$this->hts_db);
             
              return $rs;

  
  }

function multiexplode ($delimiters,$string) {
   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}







  function Create($pTitle,$pMessage,$pFrom,$pDest,$pCC=null,$pBCC=null,$pFilesPath="") {
  
  
      $this->LoadFromId(0);
      $this->SetParam(VMQ6_EMAILS_TITRE,$pTitle);
      
  //     print "aaa".$pFrom."(".intval($pFrom)." - ".$pFrom.")";
        $tmp_from = intval($pFrom);
      if("".$tmp_from!=$pFrom) {
     //  print "bbb";
        $y = new vmq6contacts($this->hts_db);
       //  print $pFrom;
         $pFrom = $y->Check($pFrom);
       //  print ":".$pFrom;
      }
      $this->SetParam(VMQ6_EMAILS_STATUS,VMQ6_EMAILS_STATUS_NEW);
      $this->SetParam(VMQ6_EMAILS_FROM,$pFrom);
      $this->SetParam(VMQ6_EMAILS_MESSAGE,$pMessage);         
      $newid = $this->Save();


      if(!is_array($pDest)) {
        $pDest = $this->multiexplode(array(",",";","\n"),$pDest);
      }
      if(!is_array($pCC)) {
        $pCC = $this->multiexplode(array(",",";","\n"),$pCC);
      }        
      if(!is_array($pBCC)) {
        $pBCC = $this->multiexplode(array(",",";","\n"),$pBCC);
      }      

      
      $z = new vmq6routing($this->hts_db);
      foreach($pDest as $item => $value) {
          $z->Add($newid,$value,VMQ6_ROUTING_TYPE_TO);
      }
      foreach($pCC as $item => $value) {
        $z->Add($newid,$value,VMQ6_ROUTING_TYPE_CC);
      }
      foreach($pBCC as $item => $value) {
        $z->Add($newid,$value,VMQ6_ROUTING_TYPE_BCC);
      }

      
      return true;  
      
               
      
  }
  
  function Event_Save_Before($pId) {
  
    if($this->GetParam(VMQ6_EMAILS_DATEINSCRIT)=="") {
      $this->SetParam(VMQ6_EMAILS_DATEINSCRIT,date('YmdHis'));
    }
  }
  

 
  function Destinataires($pId,$pType) {
  
  	          $rs = new iptDBQuery;
  	          $query="select vmq6_routing.*,vmq6_contacts.tnom,vmq6_contacts.tprenom,vmq6_contacts.tcourriel,
                          case  vmq6_routing.istatus when 0 then 'Queued' when 1 then 'Sent' when 2 then 'Error' end tstatus 
                         from vmq6_routing
                         left outer join vmq6_contacts on vmq6_contacts.id=vmq6_routing.kvmq6_contact
                         where vmq6_routing.kvmq6_email=".intval($pId)." and
                         vmq6_routing.itype=".intval($pType);
                         
      				$rs->Open($query,$this->hts_db);
               //print $query; 
              return $rs;

  
  }
  
  function NextInQueue() {
 
  	          $rs = new iptDBQuery;
  	          $query="select vmq6_routing.kvmq6_email, vmq6_emails.ttitre, vmq6_routing.kvmq6_contact,vmq6_contacts.tnom, vmq6_contacts.tprenom,vmq6_contacts.tcourriel
                         from vmq6_routing
                         left outer join vmq6_emails on vmq6_emails.id=vmq6_routing.kvmq6_email 
                         left outer join vmq6_contacts on vmq6_contacts.id=vmq6_routing.kvmq6_contact
                         where 
                         vmq6_routing.istatus=0 and
                         vmq6_emails.istatus=0 and 
                         vmq6_contacts.istatus=0 and
                         vmq6_emails.ddebut<='".date("YmdHis")."' and
                         vmq6_emails.dfin>='".date("YmdHis")."' ";
                      
                    
              $query .="
                         order by   vmq6_emails.ddebut desc, vmq6_routing.dinscrit desc, vmq6_routing.id
                         limit 1";
                         
      				$rs->Open($query,$this->hts_db);
            // print $query;
               if($rs->RowCount()>0) {
                return $rs->GetValue("kvmq6_email",0);
               } else { 
                  return false;
                } 
  
  }
  
  
  function PrepareContent($pHtml,$pBaseDir="") {
  
      $my_html = $pHtml;
      preg_match_all('/"(.*?)"/s', $my_html, $matches);
     // print_r($matches[1]); 
      
      $attachment =null;
      
      $base_cid = rand(10000,99999)."-".rand(1000000,9999999)."-".rand(1000,9999)."-";
      $no_item=0;
      
      foreach($matches[1] as $item => $value) {
      
        if(substr($value,0,5)!="http:" && substr($value,0,4)!="ftp:" ) {
           $no_item = $no_item +1;
         
           $cid=$base_cid.$no_item;
           $my_html = str_replace("\"".$value."\"","\"cid:".$cid."\"",$my_html);
           
           $newi = count($attachment);
           if(substr($value,0,1)=="/") {
            $value = substr($value,1);
           }
           
           $newfilename = strrev($value);
           $newfilename =substr(strrev($newfilename), strlen($newfilename)-strpos($newfilename, "/", 0));
           
           $attachment[$newi]['file'] =  $pBaseDir.$value;
           $attachment[$newi]['shortname'] =  $newfilename;
           $attachment[$newi]['cid'] =  $cid;
        }

      }
   
      
      $this->Content = $my_html;
      $this->Attachments = $attachment;
      return $my_html;
  
  
  }
  
  
 
  function Send() {
  
  


        $rs = $this->Infos($this->GetParam(VMQ6_EMAILS_ID));
        $nom = $rs->GetValue("tnom",0);
        $prenom = $rs->GetValue("tprenom",0);
        $courriel = $rs->GetValue("tcourriel",0);
        
      	          $rs = new iptDBQuery;
  	          $query="select vmq6_routing.id,vmq6_routing.kvmq6_email, vmq6_emails.ttitre, vmq6_routing.kvmq6_contact,vmq6_contacts.tnom, vmq6_contacts.tprenom,vmq6_contacts.tcourriel
                         from vmq6_routing
                         left outer join vmq6_emails on vmq6_emails.id=vmq6_routing.kvmq6_email 
                         left outer join vmq6_contacts on vmq6_contacts.id=vmq6_routing.kvmq6_contact
                         where 
                         vmq6_routing.istatus=0 and
                         vmq6_emails.istatus=0 and 
                         vmq6_contacts.istatus=0  
                          and vmq6_routing.kvmq6_email=".intval($this->GetParam(VMQ6_EMAILS_ID))." 
                          
                         order by   vmq6_emails.ddebut desc, vmq6_routing.dinscrit desc, vmq6_routing.id
                         limit 1";
                         
      				$rs->Open($query,$this->hts_db);  
          if(	$rs->RowCount()>0) {
                  $id_routing =   $rs->GetValue("id",0);
                $d_nom = $rs->GetValue("tnom",0);
                $d_prenom = $rs->GetValue("tprenom",0);
                $d_courriel = $rs->GetValue("tcourriel",0);
                $titre = $rs->GetValue("ttitre",0);
                 
                 if($prenom!="" || $nom !="") {       
                  $from_email = trim($prenom." ".$nom." <".$courriel.">");
                } else {
                  $from_email = $courriel;
                
                }
                
          
                $x = new iptEmail();
                $x->Init( $from_email,$this->Content);
                foreach($this->Attachments as $item => $values) {
              //  print_r($values);
                        $x->AddAttachment($values['file'], $values['shortname'],$values['cid']);
                   
                }
         //       die;
                $x->Send($d_courriel, $titre);
        
                
                $z = new vmq6routing($this->hts_db);
                $z->LoadFromId($id_routing);
                $z->SetParam(VMQ6_ROUTING_STATUS,VMQ6_ROUTING_STATUS_SENT);
                $z->SetParam(VMQ6_ROUTING_DATEENVOIE,date('YmdHis'));
                
                $z->Save();
                return 1;
            } else {
              return 0;
            }
      
  }
 
}



?>