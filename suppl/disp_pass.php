<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/autoload.php';
    $cntr = new Contr\VehPassContr();
    $util = new Model\Util();  
    $conn = new Model\Conn();
    
    if(isset($_POST['action'])) {
        $rqst = json_decode(json_encode($_POST));
        $rqst->user_id = $_SESSION['user_id'];
        $action = $rqst->action;
        switch($rqst->action) {
            case 'getVehicle'  :
                $query = "select * from veh_data where pass_id in (select max(pass_id) where zvehn = ?)";
                $param = array($rqst->vehno);
                $pass = $conn->execQuery($query,$param,1);
                $util->writeLog(json_encode($pass));
                if(isset($pass)) {
                    if($pass->cstat != 'GP') {
                        $action = 'viewPass';
                    } else {
                        $action = 'addPass';
                    }
                } else {
                    $pass = new Contr\VehPassContr();
                    $pass->zvehn = $rqst->vehno;
                    $action = 'addPass';
                }
                break;
            case 'addPass' :
                $pass = $cntr->createPass($rqst);
                $rqst->pass_id = $pass->pass_id;
                $rqst->pstatus = 'VP';
                $cntr->updtVPStatus($rqst);
                $_SESSION['status'] = 'Vehicle Pass : '.$pass->pass_id. ' Created';
                header("Location:disp_chln.php?pass_id=".$pass->pass_id);
                exit(0);
                break;
            case 'modPass' :
                $pass = $cntr->modifyPass($rqst);
                $_SESSION['status'] = 'Vehicle Pass : '.$pass->pass_id. ' Modified';
                $action = 'viewPass';
                break;
            case 'viewPass' :
                $query = "select * from veh_data where pass_id = ?";
                $param = array($rqst->pass_id);
                $pass = $conn->execQuery($query,$param,1);
                $action = 'modPass';
                break;
            case 'invPass' : 
                $query = "select * from veh_data where pass_id = ?";
                $param = array($rqst->pass_id);
                $pass = $conn->execQuery($query,$param,1);
                header("Location:disp_chln.php?pass_id=".$pass->pass_id);
                exit(0);
                break;
        }
    }
    require "../incld/header.php";
    require "../suppl/top_menu.php";
    require "../suppl/side_menu.php";

    if(isset($_GET['pass_id'])) {
        $rqst = json_decode(json_encode($_GET));
        if(!isset($action)) {
            $action = 'viewPass';
        }
        $query = "select * from veh_data where pass_id = :pass_id";
        $param = array($rqst->pass_id);
        $pass  = $conn->execQuery($query,$param,1);
    }  else {
        if(!isset($_POST['vehno'])) {
            $rqst = new stdClass();
            $action = "vehPass";
            $pass = new Contr\VehPassContr();
        }
    }
       
    $util->writeLog($action);
    $query = "select objky,objnm,werks from plants";
    $param = array();
    $plant  = $conn->execQuery($query,$param);

    $states = $util->getStates();
    $cities = $util->getCities($pass->state);
    require "../suppl/form_pass.php";
?>
<?php
    include('../incld/jslib.php');
?>
<script>

$( document ).ready(function() {
    $('.select2').select2();
    actn = $('#action').val();
    switch(actn) {
        case 'vehPass':
            $("input").attr('readonly', true);
            $("select").prop('disabled', true);
            $("input[name='vehno']").attr('readonly',false);
            $("button[name='setVeh']").attr('disabled', false);
            break;
        case 'addPass':
            $("input[name='vehno']").attr('readonly',false);
            $("button[name='setVeh']").attr('disabled', false);
            $("input[name='pass_id']").attr('readonly',true);
            $("input[name='zvehn']").attr('readonly',true);
            $("input[name='sdesc']").attr('readonly',true);
            break;
        case 'invPass':
            $("input").attr('readonly', true);
            $("select").prop('disabled', true);
            $("button[name='setVeh']").attr('disabled', true); 
            break;
        case 'modPass' :
            $("input").attr('readonly', false);
            $("select").prop('disabled', false);
            $("input[name='vehno']").attr('readonly',true);
            $("button[name='setVeh']").attr('disabled', true);
            $("input[name='pass_id']").attr('readonly',true);
            $("input[name='zvehn']").attr('readonly',true);
            $("input[name='cstat']").attr('readonly',true);
            break;
        case 'viewPass':
            $("input").attr('readonly', true);
            $("select").prop('disabled', true);
            $("button[name='setVeh']").attr('disabled', true);   
            break;
    }
});
function validateForm(obj,event) {
    debugger;
    veh = $(obj).find('input[name="vehno"]');
    msg = veh.next("span");
    if (!veh[0].checkValidity()) {
        msg.text("Invalid format (e.g., KA01AB1234)");
        event.preventDefault();
    } else {
        msg.text("Valid Vehicle Number");
    }
}
function getCities(obj) {
    let api_val = $(obj).val();
    let options = $('#zzloc');
    if(api_val=="") {
        options.empty();
    } else {
        let api_url = "https://api.countrystatecity.in/v1/countries/IN/states/"+ api_val +"/cities/";
        let api_key = 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA==';
    
        $.ajax({
            url: api_url,
            method : 'GET',
            dataType: 'json',
            headers : {
                'X-CSCAPI-KEY' : api_key,
                'Content-Type' : 'application/json'
            },
            success : function(data) {
                console.log(data);
                options.empty();
                options.append('<option value="">Select an option</option>');
                $.each(data, function(index, item) {
                    options.append('<option value="' + item.name + '">' + item.name + '</option>');
                });
            } 
        });
    }
}

    function addForm(obj) {
        $("input").attr('readonly', false);
        $("input[name='pass_id']").attr('readonly',true);
        $("input[name='zvehn']").attr('readonly',true);
        $("button[name='action']").prop("disabled",false);
    }
    function viewForm() {
        $("input").attr('readonly', true);
        $("select").prop('disabled', true);
    }
    function enInput(obj) {
        $("input").attr('readonly', false);
        $("input[name='vehno']").attr('readonly',true);
        $("button[name='setVeh']").prop("disabled",true);
        $("input[name='pass_id']").attr('readonly',true);
        $("input[name='zvehn']").attr('readonly',true);
        $("button[name='action']").prop("disabled",false);
    }
    function updt_tplst(obj) {
        let tplst = $(obj).val();
        $('#tplst').val(tplst);
    }
</script>

<?php
    include('../incld/footer.php');
?>