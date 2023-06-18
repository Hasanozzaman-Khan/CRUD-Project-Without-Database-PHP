<?php

define('DB_NAME', 'D:/Programming/PHP/Master-in-PHP/CRUD-Product-2/crud/data/db.txt');

function seed($fileName){
    $data = array(
        array(
            'id' =>1,
            'fname' => "Kamal",
            'lname' => "Ahmed",
            'roll' => 11
        ),
        array(
            'id' =>2,
            'fname' => "Jamal",
            'lname' => "Ahmed",
            'roll' => 12
        ),
        array(
            'id' =>3,
            'fname' => "Repon",
            'lname' => "Ahmed",
            'roll' => 9
        ),
        array(
            'id' =>4,
            'fname' => "Nikhil",
            'lname' => "Chandra",
            'roll' => 8
        )
    );

    $serializeData = serialize($data);

    file_put_contents($fileName, $serializeData, LOCK_EX);
};



function generateRepotr(){
    $serializeData = file_get_contents(DB_NAME);

    $students = unserialize($serializeData);
?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <?php if(hasPrivilege()): ?>
                <th>Action</th>
            <?php endif; ?>
        </tr>

        <?php foreach($students as $student) { ?>
            <tr>
                <td><?php echo $student['fname']." ".$student['lname']; ?></td>
                <td><?php echo $student['roll']; ?></td>
                <?php if(hasPrivilege()): ?>
                    <td>
                        <?php if(isAdmin()): ?>
                            <?php printf('<a href="/crud/index.php?task=edit&id=%s" class="btn btn-sm">Edit</a>', $student['id']); ?>
                            <?php printf('<a class="delete" href="/crud/index.php?task=delete&id=%s" class="btn btn-sm">Delete</a>', $student['id']); ?> 
                        <?php elseif(isEditor()): ?>
                            <?php printf('<a href="/crud/index.php?task=edit&id=%s" class="btn btn-sm">Edit</a>', $student['id']); ?>
                        <?php endif; ?>
                    <td>
                <?php endif; ?>
            </tr>
        <?php } ?>

    </table>

<?php 
    // print_r($students);
};




function addStudents($fname, $lname, $roll){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);

    foreach($students as $_student){
        if($_student['roll'] == $roll){
            $found = true;
            break;
        };
    };

    if(!$found){
        // $newId = count($students) + 1;
        $newId = getNewId($students);

        $student = array(
            'id' =>$newId,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );

        array_push($students, $student);

        $serializeData = serialize($students);

        file_put_contents(DB_NAME, $serializeData, LOCK_EX);

        // print_r($students);
        return true;
    }
    return false;

};



function getStudent($id){
    $serializeData = file_get_contents(DB_NAME);

    $students = unserialize($serializeData);

    foreach ($students as $student){
        if ($student['id'] == $id){
            return $student;
        }
    }
    return false;
              // $student = $students['id' =>4];

            //   echo var_dump($result);
              // print_r($students);
};


function updateStudents($id,$fname, $lname, $roll){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);

    $students = unserialize($serializeData);

    foreach($students as $_student){
        if($_student['roll'] == $roll && $_student['id'] != $id){
            $found = true;
            break;
        };
    };

    if(!$found){
        
        $count = count($students);
        for($i = 0; $i < $count; $i++){
            if($students[$i]['id'] == $id){
                $students[$i]['fname'] = $fname;
                $students[$i]['lname'] = $lname;
                $students[$i]['roll'] = $roll;
            }
        }

        $serializeData = serialize($students);

        file_put_contents(DB_NAME, $serializeData, LOCK_EX);

        return true;
    }
    return false;
}



function deleteStudent($id){
    $serializeData = file_get_contents(DB_NAME);

    $students = unserialize($serializeData);

    $count = count($students);

    for($i = 0; $i < $count; $i++){
        if($students[$i]['id'] == $id){
            unset($students[$i]);
            break;
        }
    }

    $serializeData = serialize($students);

    file_put_contents(DB_NAME, $serializeData, LOCK_EX);

}



function getNewId($students){
    $maxId = max(array_column($students,'id')); 
    return $maxId + 1;
}


function isAdmin(){
    if(isset($_SESSION['role']) && 'admin' == $_SESSION['role']){
        return true;
    }
}


function isEditor(){
    return (isset($_SESSION['role']) && 'editor' == $_SESSION['role']);
}


function hasPrivilege(){
    return (isAdmin() || isEditor());
}













?>