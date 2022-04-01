<?php 
include_once("../db/database.php");
include_once("../bootstrap.php");

if(isset($_GET['tab'])){
    switch ($_GET['tab']) {
        case 'groups' :
            $templateParams['groups'] = $dbh->getCollaborations($_SESSION['teacher']);
            break;
        case 'teachings':
            $templateParams['teachings'] = $dbh->getTeacherTeachings($_SESSION['teacher']);
            break;
    }
    $templateParams["components"] = array(APP_ROOT . '/template/teacher/' . $_GET['tab'] .'.php');
}

if (isset($_GET['action'])) {
    if($_GET['action'] == 'checkGroupName'){
        $response =  $dbh->checkGroupNamePresence($_GET['name']);
        if($response){
            echo json_encode(array("result" => false, "message" => "this name have been already taken"));
        } else {
            echo json_encode(array("result" => true));
        }
    } elseif ($_GET['action'] == 'getTeachingTab') {
        require APP_ROOT . '/template/teacher/edit-teaching-info.php';
        require APP_ROOT . '/template/teacher/edit-' . $_GET['teaching'] .'.php';
    } elseif ($_GET['action'] == 'checkTeacher') {
        $response = $dbh->checkUser($_GET['username']);
        if(isset($response['user'])){
            $response =  $dbh->isUserTeacher($_GET['username']);
            if(isset($response['teacher'])){
                $response = $dbh->checkCollaboration($response['CF'], $_GET['ID_group']);
                if(isset($response['collaboration'])){
                    echo json_encode(array("result" => false, "message" => "this user is already a teacher"));
                } else {
                    echo json_encode(array("result" => true));
                }
            } else {
                echo json_encode(array("result" => false, "message" => "this user is not a teacher"));
            }
        } else {
            echo json_encode(array("result" => false, "message" => "this user does not exist"));
        }
    }
} elseif (isset($_POST['action'])) {
    if($_POST['action'] == 'createGroup'){

        $group = array(
            'name' => $_POST['name'],
        );

        if(!$dbh->checkGroupNamePresence($group['name'])){
            $response =  $dbh->createGroup($group['name'], $_SESSION['teacher']);

            if($response){
                $group['collaboration'] = 1;
                $templateParams['groups'] = array($group);
                require(APP_ROOT . '/' . 'template/search-group.php' );
            } else {
                $templateParams['alert']['title'] = 'an error as occurred';
                $templateParams['alert']['content'] = 'the group could not be created';
                require(APP_ROOT . '/' . 'template/alert.php');
            }
        }
    } elseif ($_POST['action'] == 'addCollaboration') {
        if (isset($_SESSION['teacher'])) {
            $teacher = $dbh->isUserTeacher($_POST['username']);
            if (isset($teacher['CF'])) {
                $check = $dbh->checkCollaboration($teacher['CF'], $_POST['ID_group']);
                if (isset($check['group']) && isset($check['collaboration'])) {
                    //teacher is already collaborating
                } else if (isset($check['group']) && !isset($check['collaboration'])) {
                    $response = $dbh->addCollaboration($_POST['ID_group'], $teacher['CF']);
                    //$templateParams['users'] = array(0 => array('username' => $_POST['username']));
                    //echo $response ? require APP_ROOT . '/' . 'template/search-user.php' : '';
                    echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));
                } else if (!isset($check['group'])) {
                    //group does not exist
                }
            }
        }
    } elseif ($_POST['action'] == 'removeCollaboration') {
        if (isset($_SESSION['teacher'])) {
            $teacher = $dbh->isUserTeacher($_POST['username']);
            if (isset($teacher['CF'])) {
                $check = $dbh->checkCollaboration($teacher['CF'], $_POST['ID_group']);
                if (isset($check['group']) && isset($check['collaboration'])) {
                    $response = $dbh->removeCollaboration($_POST['ID_group'], $teacher['CF']);
                    echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));
                } else if (isset($check['group']) && !isset($check['collaboration'])) {
                    //teacher is not collaborating
                } else if (!isset($check['group'])) {
                    //group does not exist
                }
            }
        }

    } elseif ($_POST['action'] == 'leaveGroup') {
        $response =  $dbh->deleteCollaboration($_POST['name'], $_SESSION['teacher']);
        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));

    } elseif ($_POST['action'] == 'createTeaching'){
        $teaching = array(
            'CF' => $_SESSION['teacher'],
            'ID_group' => $_POST['teaching']['ID_group'],
            'type' => $_POST['teaching']['type'],
            'category' => $_POST['teaching']['category'],
            'name' => $_POST['teaching']['name'],
            'price' => $_POST['teaching']['price'],
            'category_detail' => $_POST['teaching']['category_detail'],
            'description' => $_POST['teaching']['description'],
            'creation_date' => date("y-m-d"),
            'content' => $_POST['teaching']['content'],
            'active' => $_POST['teaching']['active']
        );


        if (isset($_SESSION['teacher'])) {
            $response = $dbh->checkCollaboration($_SESSION['teacher'], $teaching['ID_group']);
            if (isset($response['collaboration']) && isset($response['group'])) {
            } elseif (!isset($response['collaboration']) && isset($response['group'])) {
                echo json_encode(array("result" => false, "message" => "you do not collaborate with this group"));
                return;
            } elseif (isset($response['group'])) {
                echo json_encode(array("result" => false, "message" => "this group does not exist"));
                return;
            }
        } else {
            echo json_encode(array("result" => false, "message" => "this user is not a teacher"));
            return;
        }

        $ID_teaching =  $dbh->createTeaching(
            $teaching['teacher'],
            $teaching['ID_group'],
            $teaching['type'],
            $teaching['category'],
            $teaching['name'],
            $teaching['price'],
            $teaching['category_detail'],
            $teaching['description'],
            $teaching['creation_date'],
            $teaching['content'],
            $teaching['active']
        );

        echo isset($ID_teaching) ? json_encode(array("result" => true, 'ID_group' => $teaching['ID_group'], 'ID_teaching' => $ID_teaching)) : json_encode(array("result" => false));
    } elseif ($_POST['action'] == 'updateTeaching'){
        $teaching = array(
            'CF' => $_SESSION['teacher'],
            'ID_group' => $_POST['teaching']['ID_group'],
            'ID_content' => $_POST['teaching']['ID_content'],
            'type' => $_POST['teaching']['type'],
            'category' => $_POST['teaching']['category'],
            'name' => $_POST['teaching']['name'],
            'price' => $_POST['teaching']['price'],
            'category_detail' => $_POST['teaching']['category_detail'],
            'description' => $_POST['teaching']['description'],
            'content' => $_POST['teaching']['content'],
            'active' => $_POST['teaching']['active']
        );

        $response =  $dbh->updateTeaching(
            $teaching['CF'],
            $teaching['ID_content'],
            $teaching['ID_group'],
            $teaching['type'],
            $teaching['category'],
            $teaching['name'],
            $teaching['price'],
            $teaching['category_detail'],
            $teaching['description'],
            $teaching['content'],
            $teaching['active']
        );
        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));

    }
}

?>


