<?php
    require '../incld/verify.php';
    require '../suppl/check_auth.php';
    require '../incld/autoload.php';
    $util = new Model\Util();
    $rqst = json_decode(json_encode($_GET));
    if(isset($rqst->role_id)) {
        $query = "select * from usr_role where role_id = ?";
        $param = array($rqst->role_id);
        $role  = $conn->execQuery($query,$param,1);
        echo json_encode($role);
        die();    
    }
    if(isset($rqst->objty)) {
        $query = "select * from obj_type where objty = ?";
        $param = array($rqst->objty);
        $objty = $conn->execQuery($query,$param,1);
        $query = "select objky,objnm from {$objty->table} where objky not in (select objky from usr_auth where user_id = ? and objty = ? )";
        $param = array($rqst->user_id,$rqst->objty);
        $items = $conn->execQuery($query,$param);
        echo json_encode($items);
        die();
    }
    if(isset($rqst->role_nm)) {
        $query = "select * from usr_role where role_nm = ?";
        $param = array($rqst->role_nm);
        $role  = $util->execQuery($query,$param,1);
        $actn  = 'add';
    }
    if(isset($rqst->user_id)) {
        $query = "select * from usr_data where user_id = ?";
        $param = array($rqst->user_id);
        $user  = $util->execQuery($query,$param,1);
        $query = "select * from usr_role where role_id = ?";
        $param = array($user->role_id);
        $role  = $util->execQuery($query,$param,1);
        $actn  = 'view';
    }
    $rqst = json_decode(json_encode($_POST));
    $cntr = new Contr\UserContr();
    if(isset($rqst->setUser)) {
        $actn = $rqst->setUser;
        switch($actn) {
            case 'add' :
                $user = $cntr->createUser($rqst);
                $query = "select * from usr_data where user_id = ?";
                $param = array($rqst->user_id);
                $user  = $conn->execQuery($query,$param,1);
                $_SESSION['status'] = "User : {$user->user_id} Created";
                $actn = 'view';
                break;
            case 'mod' :
                $item = $cntr->modifyUser($rqst);
                $_SESSION['status'] = "User : {$item->user_id} Modified";
                $actn = 'view';
                break;
            case 'view' :
                $action = 'mod';
                break;
        }
    } 
    require '../incld/header.php';
    require '../admin/top_menu.php';
    require '../admin/side_menu.php';

    
    if(isset($_REQUEST['user_id'])) {
        $rqst = json_decode(json_encode($_REQUEST));
        if ($action == "") {
            $action = "view";
        }
        $query = "select * from usr_data where user_id = ?";
        $param = array($rqst->user_id);
        $user  = $conn->execQuery($query,$param,1);
        
        $query = "select * from usr_role where role_id = ?";
        $param = array($user->role_id);
        $role = $conn->execQuery($query,$param,1);

        $query = "select * from obj_type where objty = ?";
        $param = array($user->objty);
        $objt  = $conn->execQuery($query,$param,1);
        
        $query = "select objky,objnm from {$objt->table}";
        $param = array();
        $items = $conn->execQuery($query,$param);
    } else {
        $user = new Contr\UserContr();
    }
    require '../admin/form_user.php'; 
    require '../incld/jslib.php'; ?>
<script>
    $( document ).ready(function() {
        text = $('#action').val();
        switch(text) {
            case 'add':
                $("input").attr('readonly', false);
                $("select").prop('disabled', false);
                break;
            case 'mod' :
                $("input").attr('readonly', false);
                $("select").prop('disabled', false);
                $("input[name='user_id']").attr('readonly',true);
                break;
            case 'view':
                $("input").attr('readonly', true); 
                $("select").prop('disabled', true);
                break;
        }
    });
    function btnToggle(obj,event) {
        debugger;
        if (obj.type === "button") {
                form = $(obj).closest('form');
                form.find("input").prop('readonly',false);
                form.find("select").prop('disabled',false);
                obj.type = "submit"; // ✅ Change to submit
                event.preventDefault();
                obj.innerHTML = '<i class="fa fa-save"></i>';
        } 
    }
    function setObjty(obj) {
        let role_id = $(obj).val();
        $.get(window.location.href,{role_id:role_id},function(data){
            data = JSON.parse(data);
            console.log(data.aobj_ty);
            $('#objty').val(data.aobj_ty);
        });
    }
    function getObjects(obj,) {
        let objty = $(obj).val();
        let value = $('#objky').val();
        options = $('#objky');
        $.get(window.location.href, { objty: objty }, function(data) {
            data = JSON.parse(data);
            options.empty();
            options.append("<option value=''>Select a Object</option>");
            for (let i = 0; i < data.length; i++) {
                console.log("Object : "+ i + data[i].objky + data[i].objnm);
                options.append("<option value='"+data[i].objky+"'>"+data[i].objky + " : " + data[i].objnm+"</option>");
            }
        });
        options.val(value);
    }
</script>
<?php
    require '../incld/footer.php';
?>