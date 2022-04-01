<?php

use LDAP\Result;

use function PHPSTORM_META\type;

class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if($this->db->connect_error){
            die("Connesione fallita al db");
        }
    }
    
    public function checkLogin($username, $password){
        $stmt = $this->db->prepare("SELECT username, username, password 
        FROM user 
        WHERE username = ?");

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        return password_verify($password,$result["password"]);
    }   

    public function checkUser($username){
        $query = "SELECT 1 user
        FROM user
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }   


    public function getUserEmail($username){
        $query = "SELECT email
        FROM user
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['email'];
    } 

    public function getUsernameFromProfile($ID_profile){
        $query = "SELECT ID_profile
        FROM `profile`
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['ID_profile'];
    }


    public function registerUser($username, $email, $password){
        $stmt = $this->db->prepare("INSERT INTO user (username, email, password) 
        VALUES (?, ?, ?)");
        $stmt->bind_param('sss' ,$username, $email, password_hash($password, PASSWORD_BCRYPT));

        $stmt2 = $this->db->prepare("INSERT INTO profile (username, private) 
        VALUES (?,0)");
        $stmt2->bind_param('s' ,$username);

        $result1 = $stmt->execute();
        $result2 = $stmt2->execute();

        return $result1 && $result2;
    }   

    public function checkUsernamePresence($username){
        $query = "SELECT 1 AS presence
        FROM user 
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' ,$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }   

    public function checkEmailPresence($email){
        $query = "SELECT 1 presence  
        FROM user 
        WHERE email = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' ,$email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    } 

    public function getProfilePostsFromUser($username){
        $query = "SELECT * 
        FROM post 
        WHERE ID_profile = (SELECT ID_profile 
            FROM profile 
            WHERE username = ?) 
        ORDER BY post.date ASC, post.time ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' ,$username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    public function getProfile($username){
        $query = "SELECT ID_profile, private
        FROM profile 
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' ,$username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    //TODO: controllare che il profilo esista
    //TODO: controllare che i due utenti siano amici o che il prifilo sia di chi sta creano il post

    public function createPost($username, $ID_profile, $content, $date, $time){
        $query = "INSERT INTO post (ID_profile, username, content, date, time, n_comments) 
        VALUES (?, ?, ?, DATE(?), TIME(?), 0)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss' , $ID_profile, $username, $content, $date, $time);
        return $stmt->execute();
    }  

    public function createComment($username, $post_ID_profile, $post_username, $content, $date, $time, $post_date, $post_time){
        $query1 = "INSERT INTO comment (username, post_ID_profile, post_username, content, date, time, post_date, post_time) 
        VALUES (?, ?, ?, ?, DATE(?), TIME(?), DATE(?), TIME(?))";

        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('sissssss' , $username, $post_ID_profile, $post_username, $content, $date, $time, $post_date, $post_time);
        $result1 = $stmt1->execute();

        $query2 = "UPDATE post 
        SET n_comments = n_comments + 1 
        WHERE username = ? 
        AND ID_profile = ? 
        AND date = ? 
        AND time = ?";

        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('siss' , $post_username, $post_ID_profile, $post_date, $post_time);
        $result2 = $stmt2->execute();

        return $result1 && $result2;
    }  

    /**
     * retrieve all the comments from a post
     */
    public function getCommentsFromPost($username, $ID_profile, $date, $time){
        $query = "SELECT * 
        FROM comment 
        WHERE post_username = ? 
        AND post_ID_profile = ? 
        AND post_date = DATE(?) 
        AND post_time = TIME(?) 
        ORDER BY date DESC, time DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('siss' , $username, $ID_profile, $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    public function deletePost($username, $ID_profile, $date, $time){
        $query1 = "DELETE FROM post 
        WHERE username = ? 
        AND ID_profile = ? 
        AND date = DATE(?) 
        AND time = TIME(?)";
        
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('siss' , $username, $ID_profile, $date, $time);
        $result1 = $stmt1->execute();

        //update number of posts
        /* 
        $query2 = "UPDATE profile SET n_post = n_post - 1 WHERE ID_profile = ?";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('s' , $ID_profile);
        $result2 = $stmt2->execute();
        */

        return $result1;
    } 

    //TODO: inserire controlli : esiste, accessibilità (è sul profilo di chi lo vuole eliminare, è di chi lo vuole eliminare)
    /**
     * delete a comment and update the number of comments of the target post
     */
    public function deleteComment($username, $post_ID_profile, $post_username, $date, $time, $post_date, $post_time){
        $query1 = "DELETE FROM comment 
        WHERE username = ? 
        AND post_ID_profile = ? 
        AND post_username = ? 
        AND date = DATE(?) 
        AND time = TIME(?) 
        AND post_date = DATE(?) 
        AND post_time = TIME(?)";

        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('sisssss' , $username, $post_ID_profile, $post_username, $date, $time, $post_date, $post_time);
        $result1 = $stmt1->execute();

        $query2 = "UPDATE post 
        SET n_comments = n_comments - 1 
        WHERE username = ? 
        AND ID_profile = ? 
        AND date = DATE(?) 
        AND time = TIME(?)";

        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('siss' , $post_username, $post_ID_profile, $post_date, $post_time);
        $result2 = $stmt2->execute();

        return $result1 && $result2;
    } 

    public function getUsers($username){
        $query = "SELECT username 
        FROM user 
        WHERE username != ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' ,$username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    /**
     * check if two users are friends
     */
    public function areUsersFriends($username_1,$username_2){
        $query = "SELECT 1 AS friendship
        FROM friendship
        WHERE user_1=?
        AND user_2=?
        OR user_2=?
        AND user_1=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $username_1, $username_2, $username_1, $username_2);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * retrieve a list of all the users specifiyng whether thay are friends with the specified one
     */
    public function getUsersListWithFriends($username_1, $f=true){
        $friendship = $f ? ", friendship" : "";
        $query = "SELECT username $friendship
        FROM (SELECT T.user_2, 1 as friendship
              FROM (SELECT user_1, user_2 
                    FROM friendship
                    WHERE user_1 = ?
                    UNION
                    SELECT user_2 user_1, user_1 user_2 
                    FROM friendship
                    WHERE user_2 = ?) T) F
               RIGHT OUTER JOIN (SELECT username
                                 FROM user
                                 WHERE username != ?) U
               ON F.user_2 = U.username";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $username_1, $username_1, $username_1);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //TODO: inserire controlli su presenza amico e amicizia
    /**
     * create a friendship between two users
     */
    public function addFriendship($username_1, $username_2, $date){
        $query = "INSERT INTO friendship (user_1, user_2, date) 
        VALUES (?, ?, DATE(?))";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss' , $username_1, $username_2, $date);
        return $stmt->execute();
    }  

    //TODO: inserire controlli su presenza amico e amicizia
    /**
     * delete a friendship between two users
     */
    public function deleteFriendship($username_1, $username_2){
        $query = "DELETE FROM friendship 
        WHERE user_1 = ? 
        AND user_2 = ?
        OR user_1 = ? 
        AND user_2 = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss' , $username_1, $username_2, $username_2, $username_1);
        return $stmt->execute();

        //to update number of friends
    }  

    /**
     * retrieve the friends of a user
     */
    public function getUserFriends($username, $f=true){
        $friendship = $f ? ", 1 AS friendship" : "";
        $query = "SELECT A.user_2 username $friendship
        FROM (SELECT a1.user_1, a1.user_2 
              FROM friendship a1
              WHERE user_1 = ?
        
              UNION
        
              SELECT a2.user_2 user_1, a2.user_1 user_2 
              FROM friendship a2
              WHERE user_2 = ?) A";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss' , $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }  

    /**
     * retrieve all the posts on the profile of a user and all of its firends
     */
    public function getPostsByUserAndFriends($username){
        $query = "SELECT *
        FROM (
            SELECT * 
            FROM post 
            WHERE username IN ( 
                SELECT F1.user_2 
                FROM friendship F1 
                WHERE user_1 = ?
                UNION 
                SELECT F2.user_1 user_2 
                FROM friendship F2 
                WHERE user_2 = ?)
            OR username = ?) P
        
        INNER JOIN (
            SELECT username p_username, ID_profile
            FROM profile
        ) AS U ON P.ID_profile = U.ID_profile
        ORDER BY date ASC, time ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss' , $username, $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }  

    /**
     * retrieve the teacher information about a user
     */
    public function getTeacherInfo($username){
        $query = "SELECT name, surname, bday, CF
        FROM teacher 
        WHERE username = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' , $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    //TODO: remove duplicate feature, this should not be editable
    //TODO: add CF control
    /**
     * set the required information to become a teacher
     */
    public function updateTeacher($username, $name, $surname, $bday, $CF){
        $query = "INSERT INTO teacher (username, name, surname, bday, CF)
        VALUES (?, ?, ?,  DATE(?), ?)
        ON DUPLICATE KEY UPDATE name=?, surname=?, bday=DATE(?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssss' , $username, $name, $surname, $bday, $CF, $name, $surname, $bday);
        return $stmt->execute();
    }  

    /**
     * update privacy settings of a profile
     */
    public function updatePrivacySettings($ID_profile, $private){
        $query = "UPDATE profile 
        SET private = ?
        WHERE ID_profile = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii' , $private, $ID_profile);
        return $stmt->execute();
    } 

    /**
     * retrieve privacy settings of a profile
     */
    public function getPrivacySettings($ID_profile){
        $query = "SELECT private
        FROM profile 
        WHERE ID_profile = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s' , $ID_profile);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * check is a user is teacher
     */
    public function isUserTeacher($username)
    {
        $query = "SELECT 1 teacher, CF
        FROM teacher
        WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * get teachings that a user haven't bought yet grouped by category
     */
    public function getTeachings($username = null)
    {
        if(isset($username)){
            $query = "SELECT *
            FROM `teaching`
            WHERE ID_content NOT IN (
                SELECT P.ID_content
                FROM `transaction` T
                JOIN `purchase` P ON P.ID_transaction = T.ID_transaction
                WHERE username = ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
        } else {
            $query = "SELECT *
            FROM `teaching`";
            $stmt = $this->db->prepare($query);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = []; //the array to hold the restructured data

        //group the rows from different categories together
        $cat = null;
        while ($row = $result->fetch_assoc()) {
            if ($row["category"] != $cat) {
                $cat = $row["category"]; //category id of current row
            }
            $categories[$cat][] = $row; //push row into correct array
        }

        return $categories;
    }

    /**
     * get transactions of a user and the respective products
     */
    public function getTransactions($username )
    {
        $query = "SELECT *
        FROM transaction T, purchase P
        JOIN teaching T2 ON T2.ID_content = P.ID_content
        WHERE T.ID_transaction = P.ID_transaction
        AND T.username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $transactions = []; //the array to hold the restructured data

        //group the rows from different transactions together
        $tran = null;
        while ($row = $result->fetch_assoc()) {
            if ($row["ID_transaction"] != $tran) {
                $tran = $row["ID_transaction"]; //transaction id of current row
            }
            $transactions[$tran][] = $row; //push row into correct array
        }

        return $transactions;
    }

    /**
     * retrieve the available categories
     */
    public function getCategories()
    {
        $query = "SELECT name
        FROM category";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * get teachings that a user haven't bought yet of a specified category
     */
    public function getTeachingsByCategory($category, $username=null)
    {
        if(isset($username)){
            $query = "SELECT *
            FROM `teaching`
            WHERE ID_content NOT IN (
                SELECT P.ID_content
                    FROM `transaction` T
                    JOIN `purchase` P ON P.ID_transaction = T.ID_transaction
                    WHERE username = ?)
            AND category = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $username,$category);
        } else {
            $query = "SELECT *
            FROM `teaching`
            WHERE category = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $category);
        }
        
        $query = "SELECT *
        FROM teaching
        WHERE category = ?";

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * get the information of a list of products
     */
    public function getCartProducts($products)
    {
        $in  = str_repeat('?,', count($products) - 1) . '?';
        $query = "SELECT * 
        FROM teaching
        WHERE ID_content IN ($in)";

        $stmt  = $this->db->prepare($query);
        $types = str_repeat('s', count($products));
        $stmt->bind_param($types, ...$products);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    /**
     * check if a group exist and if a teacher collaborates with it
     */
    public function checkCollaboration($CF, $ID_group){
        $query = "SELECT P.group, C.collaboration
        FROM (
            SELECT DISTINCT ID_group, 1 AS `group`
            FROM `collaboration`
            WHERE ID_group = ?) AS P
        
        LEFT JOIN (
            SELECT ID_group, 1 AS `collaboration`
            FROM `collaboration`
            WHERE CF=?) AS C ON C.ID_group = P.ID_group";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $ID_group, $CF);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getGroup($ID_group){
        $query = "SELECT *
        FROM `group`
        WHERE ID_group=?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ID_group);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * 
     */
    public function checkTeaching($ID_content, $ID_group){
        $query = "SELECT T.teaching, G.group
        FROM (SELECT ID_group, 1 AS `teaching`
        FROM `teaching`
        WHERE ID_content=?) AS T
                
        LEFT JOIN (SELECT ID_group, 1 AS `group`
        FROM `group`
        WHERE ID_group=?) AS G ON G.ID_group = T.ID_group";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $ID_content, $ID_group);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    /**
     * get all the groups with which a teacher collaborates
     */
    public function getCollaborations($CF)
    {
        $query = "SELECT C.ID_group, G.name, 1 AS 'collaboration'
        FROM `collaboration` AS C
        INNER JOIN `group` AS G ON (C.ID_group = G.ID_group)
        INNER JOIN `teacher` AS T ON (T.CF = C.CF)
        WHERE T.CF = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $CF);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * check is there is already a group with the specified name
     */
    public function checkGroupNamePresence($name)
    {
        $query = "SELECT 1 AS `presence`
        FROM `group`
        WHERE name = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['presence'];
    }

    /**
     * create a new group
     */
    public function createGroup($name, $CF){
        $query1 = "INSERT INTO `group` (`name`) 
        VALUES (?)";

        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('s' , $name);
        $result1 = $stmt1->execute();

        $query2 = "INSERT INTO `collaboration`(`ID_group`, `CF`) 
        VALUES ((SELECT `ID_group` 
            FROM `group` 
            WHERE name = ?)
            , ?)";

        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('ss', $name, $CF);
        $result2 = $stmt2->execute();

        return $result1 && $result2;
    }  

    /**
     * delete an existing collaboration
     */
    public function deleteCollaboration($name, $CF){
        $query = "DELETE FROM `collaboration` 
        WHERE `ID_group` = ?
        AND `CF` = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss' , $CF, $name);
        $result = $stmt->execute();

        return $result;
    }

    /**
     * get all the teachings of the groups with which the teacher collaborate with
     */
    public function getTeacherTeachings($CF) {
        $query = "SELECT G.name 'group_name', T.name 'teaching_name', T.type, T.category, T.creation_date, G.ID_group, T.ID_content
        FROM (SELECT * FROM `collaboration` WHERE `CF` = ?)  AS C
        INNER JOIN `group` AS G ON (C.ID_group = G.ID_group) 
        INNER JOIN `teaching` AS T ON (T.ID_group = C.ID_group)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $CF);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCollaborators($ID_group) {
        $query = "SELECT T.name, T.surname, t.username
        FROM `teacher` AS T
        JOIN (SELECT * FROM `collaboration` WHERE `ID_group` = ?) AS G ON (T.CF = G.CF)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ID_group);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGroupTeachings($ID_group) {
        $query = "SELECT T.name 'teaching_name', T.type, T.category, T.creation_date, T.ID_group, T.ID_content
        FROM `teaching` AS T
        WHERE ID_group = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ID_group);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Resurns a list of users who share common friends whith the specified user but that are not already friends.
     * The list is ordered descending based on how many common friends the target user share with them.
     * 
     * Due to the mirror feature of the relation 'friendship' the query needs to recostruct the information step by step.
     * The query is split in two main parts, each one get the friends in a transitive way in distance of 1 from the user target, (the friends of direct friends of the user target) and reconstruct half the information.
     * Each of the two main parts is also split in two inner parts, where the transitive friendships are reconstructed through a join between the direct friends of the target user and the whole friendships.
     * Each join retrieve 1/4 of the whole information, so 4 are performed in the whole process.
     * The users found in each of the two main parts of the query are then discarded if already being friends of the user target.
     * Lastly from the users is discarded the user itself if present.
     * Duplicated occurrences are counted in order to be classified in descending orde
     * 
     * @param string $username : the username of the target user
     * @param int $n : the maximum number of users to retrieve
     *                 Default : 5
     * 
     * @return array $args {
     *      @type string $username : username of the user
     * }
     */

    public function getSuggestedUsersFromFriends($username, $n=5){

        $user_friends = "(SELECT user_1, user_2 
            FROM friendship
            WHERE user_1 = '$username'
            UNION
            SELECT user_2 user_1, user_1 user_2 
            FROM friendship
            WHERE user_2 = '$username')";
        
        $friends = "(SELECT user_2 
            FROM friendship
            WHERE user_1 = '$username'
            UNION
            SELECT user_1 user_2 
            FROM friendship
            WHERE user_2 = '$username')";

        

        $query = "SELECT T.user_2 username, COUNT(T.user_2) AS n
        FROM (
            SELECT *
            FROM (
                SELECT F1.user_1, F1.user_2
                FROM $user_friends F
                JOIN friendship AS F1 ON F.user_2 = F1.user_1
                WHERE F.user_1 != F1.user_1
        
                UNION
        
                SELECT F2.user_1, F2.user_2
                FROM $user_friends F
                JOIN friendship AS F2 ON F.user_2 = F2.user_2
                WHERE F.user_1 != F2.user_1) AS T
                
            WHERE T.user_1 NOT IN $friends
        
            UNION
        
            SELECT *
            FROM (
                SELECT F1.user_1, F1.user_2
                FROM $user_friends F
                JOIN friendship AS F1 ON F.user_2 = F1.user_1
                WHERE F.user_1 != F1.user_1
        
                UNION
        
                SELECT F2.user_1, F2.user_2
                FROM $user_friends F
                JOIN friendship AS F2 ON F.user_2 = F2.user_2
                WHERE F.user_1 != F2.user_1) AS T

            WHERE T.user_2 NOT IN $friends
        ) AS T
        WHERE user_2 != ?
        GROUP BY T.user_2
        ORDER BY n
        LIMIT ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $username,$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Resurns a list of users who share common interests whith the specified user but that are not already friends.
     * The list is ordered descending based on how many common purchases the target user share with them.
     * 
     * In the first place all the purchases made from the target user are retrieved, 
     * then the information about all the users who also bouth these same products are reconstructed.
     * All the users that are already friends with the target one are discarded and then they are counted and ordered 
     * based on how many common purchases they share.
     * 
     * @param string $username : the username of the target user
     * @param int $n : the maximum number of users to retrieve
     *                 Default : 5
     * 
     * @return array $args {
     *      @type string $username : username of the user
     * }
     */

    public function getSuggestedUsersFromPurchases($username, $n=5){

        $query = "SELECT T.username, COUNT(T.username) n
        FROM(
            SELECT P.ID_content
            FROM transaction T
            JOIN purchase P ON T.ID_transaction = P.ID_transaction
            JOIN user U ON U.username = T.username
            WHERE U.username = ?) AS C
        JOIN purchase AS P ON C.ID_content = P.ID_content
        JOIN transaction AS T ON T.ID_transaction = P.ID_transaction
        WHERE T.username != ?
        AND T.username NOT IN (
            SELECT user_2 
            FROM friendship
            WHERE user_1 = ?
            UNION
            SELECT user_1 user_2 
            FROM friendship
            WHERE user_2 = ?)
        GROUP BY T.username
        LIMIT ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssi', $username,$username,$username,$username,$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSuggestedProductsFromPurchases($username, $n=5){
        $query = "SELECT *
        FROM(
            SELECT C.ID_content, C.n
            FROM (
                SELECT P.ID_content, COUNT(P.ID_content) n
                FROM (
                    SELECT T.username
                    FROM purchase P
                    JOIN transaction T ON T.ID_transaction = P.ID_transaction
                    WHERE ID_content IN (
                        SELECT P.ID_content
                        FROM purchase P, transaction T
                        WHERE P.ID_transaction = T.ID_transaction
                        AND username =?)
                    AND T.username != ? ) AS U
                JOIN transaction T ON T.username = U.username
                JOIN purchase P ON P.ID_transaction = T.ID_transaction
                GROUP BY P.ID_content ) AS C
            JOIN teaching T ON T.ID_content = C.ID_content
            WHERE T.ID_content NOT IN (
                SELECT P.ID_content
                FROM purchase P, transaction T
                WHERE P.ID_transaction = T.ID_transaction
                AND username =?)
            ORDER BY C.n
            LIMIT ?) AS P
        JOIN teaching T ON T.ID_content = P.ID_content";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $username,$username,$username,$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * create a new transaction and returns the corresponding ID
     */
    public function createTransaction($username, $amount, $discount=0, $date, $time)
    {
        $query = "INSERT INTO `transaction`(`amount`, `discount`, `date`, `time`, `username`)
        VALUES (?,?,DATE(?),TIME(?),?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ddsss',$amount, $discount, $date, $time, $username);
        $result = $stmt->execute();
        
        if($result){
            $query2 = "SELECT ID_transaction
            FROM `transaction`
            WHERE username = ?
            AND date = DATE(?)
            AND time = TIME(?)";
            
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bind_param('sss', $username, $date, $time);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            return $result2->fetch_row()[0];
        }
        
        return null;
    }

    /**
     * check which products have already been purchased from the specified list and returns them in case
     */
    public function checkProducts($username, $products)
    {
        $in  = str_repeat('?,', count($products) - 1) . '?';
        $query = "SELECT T2.name, T2.ID_content
        FROM purchase AS P
        JOIN (SELECT * FROM `transaction` WHERE username = ?) AS T ON T.ID_transaction = P.ID_transaction
        JOIN teaching AS T2 ON P.ID_content = T2.ID_content
        WHERE P.ID_content IN ($in)";

        $stmt  = $this->db->prepare($query);
        $types = str_repeat('s', count($products));
        $stmt->bind_param('s'.$types, $username, ...$products);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertPurchase($ID_transaction, $ID_content, $price){
        $query = "INSERT INTO `purchase`(`ID_content`, `ID_transaction`, `price`)
        VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iid', $ID_content, $ID_transaction, $price);
        return $stmt->execute();
    }

    /**
     * create a new teaching
     */
    public function createTeaching($CF, $ID_group, $type, $category, $name, $price, $category_detail, $description, $creation_date, $content, $active){
        $query = "INSERT INTO `teaching` (`price`, `description`, `creation_date`, `category_detail`, `category`, `ID_group`, `name`, `type`, `active`)
        VALUES (?, ?, DATE(?), ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('dssssissi', $price, $description, $creation_date, $category_detail, $category, $ID_group, $name, $type, $active);
        $result = $stmt->execute();

        $ID_content = $this->db->insert_id;

        if($ID_content){
            switch($type){
                case 'masterclass':
                    $query = "INSERT INTO `masterclass` (`ID_content`, `content`)
                    VALUES (?,?)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('is', $ID_content, $content['content']);
                    $result = $stmt->execute();
                    break;
                case 'webinair':                    
                    if(isset($content['n_presences'])){
                        $query = "INSERT INTO `webinair` (`ID_content`,`date`, `time`, `n_presences`)
                        VALUES (?,DATE(?),TIME(?),?)";
                        $stmt = $this->db->prepare($query);
                        $stmt->bind_param('issi', $ID_content, $content['date'], $content['time'], $content['n_presences']);
                    } else {
                        $query = "INSERT INTO `webinair` (`ID_content`,`date`, `time`)
                        VALUES (?,DATE(?),TIME(?))";
                        $stmt = $this->db->prepare($query);
                        $stmt->bind_param('iss', $ID_content, $content['date'], $content['time']);
                    }
                    $result = $stmt->execute();
                    break;
            }
        }

        return $result ? $ID_content : null;
    }

    /**
     * update a teaching and its content
     */
    public function updateTeaching($CF, $ID_content, $ID_group, $type, $category, $name, $price, $category_detail, $description, $content, $active){
        $query = "UPDATE `teaching`
        SET `price` = ?, `description` = ?, `category_detail` = ?, `category` = ?, `name` = ?, `active` = ?
        WHERE `ID_content` = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('dsssssi', $price, $description, $category_detail, $category, $name, $active, $ID_content);
        $result = $stmt->execute();

        if($result){
            switch($type){
                case 'masterclass':
                    $query = "UPDATE `masterclass`
                    SET content = ?
                    WHERE ID_content = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('si', $content['content'], $ID_content);
                    $result = $stmt->execute();
                    break;
                case 'webinair':
                    if(isset($content['n_presences'])){
                        $query = "UPDATE `webinair`
                        SET date = DATE(?), time = TIME(?), n_presences = ?
                        WHERE ID_content = ?";
                        $stmt = $this->db->prepare($query);
                        $stmt->bind_param('sssi', $content['date'], $content['time'], 'NULL', $ID_content);
                    } else {
                        $query = "UPDATE `webinair`
                        SET date = DATE(?), time = TIME(?)
                        WHERE ID_content = ?";
                        $stmt = $this->db->prepare($query);
                        $stmt->bind_param('ssi', $content['date'], $content['time'], $ID_content);
                    }

                    $result = $stmt->execute();
                    break;
            }
        }

        return $result;
    }

    /**
     * get a teaching and its content
     */
    public function getTeaching($ID_content){
        $query = "SELECT *
        FROM teaching
        WHERE ID_content = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ID_content);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC)[0];

        if(isset($result['type'])){
            $type = $result['type'];
            $query = "SELECT *
            FROM $type
            WHERE ID_content = ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $ID_content);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $result['content'] = $result2->fetch_all(MYSQLI_ASSOC)[0];
        }
        return $result;
    }

    /**
     *  add a collaboration between a teacher and a group
     */
    public function addCollaboration($ID_group, $CF){
        $query = "INSERT INTO `collaboration` (`ID_group`, `CF`)
        VALUES (?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $ID_group, $CF);
        $result = $stmt->execute();
        return $result;
    }

    public function removeCollaboration($ID_group, $CF){
        $query = "DELETE FROM `collaboration`
        WHERE ID_group = ?
        AND CF = ?";
    
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $ID_group, $CF);
        $result = $stmt->execute();
        return $result;
    }

    public function dummy(){
        $query = "SELECT 


SELECT *
FROM (
    SELECT * 
    FROM post 
    WHERE username IN ( 
        SELECT F1.user_2 
        FROM friendship F1 
        WHERE user_1 = 'user1'
        UNION 
        SELECT F2.user_1 user_2 
        FROM friendship F2 
        WHERE user_2 = 'user1')
    OR username = 'user1') P
INNER JOIN (
    SELECT username p_username, ID_profile
    FROM profile) AS U ON P.ID_profile = U.ID_profile
ORDER BY date ASC, time ASC

        
        ";
    }
}







