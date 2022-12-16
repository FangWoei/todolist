<?php 

$database = new PDO(
  'mysql:host=devkinsta_db;
  dbname=Todolist',
  'root',
  'WaoDc0cvoNR1eUiM'
);

$query = $database->prepare('SELECT * FROM todolist');
$query->execute();
$todolist = $query->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
  
  if($_POST['action']==='add'){
      $statement=$database->prepare("INSERT INTO todolist (`task`) VALUES (:thetask) ");
      $statement->execute([
          'thetask'=> $_POST['addtask']
      ]);
      header('Location:/');
      exit;
  }
  elseif($_POST['action']==='delete'){
      $statement=$database->prepare("DELETE FROM todolist WHERE id=:tid");
      $statement->execute([
         'tid'=>$_POST['taskid']
      ]);
      header('Location:/');
      exit;
  }

  elseif($_POST['action']==='update'){

    if($_POST['is_complete']==0){
      $statement=$database->prepare("UPDATE todolist SET `is_complete`=1 WHERE id=:tid");
    }elseif($_POST['is_complete']==1){
      $statement=$database->prepare("UPDATE todolist SET `is_complete`=0 WHERE id=:tid");
    }

      $statement->execute([
        'tid'=>$_POST['taskid']
      ]);
      header('Location:/');
      exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>todolist</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
  />
  <style type="text/css">
    body {
      background: #f1f1f1;
    }

  </style>
</head>
<body>
  <div
    class="card rounded shadow-sm"
    style="max-width: 500px; margin: 60px auto;"
  >
    <div class="card-body">
      <h3 class="card-title mb-3">My Todo List</h3>
      <ul class="list-group">
          <?php foreach($todolist as $tasks):?>
              <li
          class="list-group-item d-flex justify-content-between align-items-center"
        >
        <?php
     

        ?>
            <div class="d-inline-block d-flex">
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']?>">
                  <input type="hidden" name="action" value="update">
                  <input type="hidden" name="taskid" value="<?php echo $tasks['id'] ;?>">
              <input type="hidden" name="is_complete" value="<?php echo $tasks['is_complete'] ;?>">
           <?php if($tasks['is_complete']==1) :?>
            <button class="btn btn-sm btn-success">
              <i class="bi bi-check-square"></i>
            </button>
            <?php else: ?>
              <button class="btn btn-sm btn-light">
                <i class="bi bi-square"></i>
                <?php endif;?>    
            </form>
            

          <span class="ms-2">
           <?php echo $tasks['task']; ?>
            </span>
          </div>
          <div>
              <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="taskid" value="<?php echo $tasks['id'] ;?>">
                  <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i>
                  </button>
              </form>
          </div>
        </li>
              <?php endforeach;?>
        
        <!-- <li
          class="list-group-item d-flex justify-content-between align-items-center"
        >
          <div>
            <button class="btn btn-sm btn-light">
              <i class="bi bi-square"></i>
            </button>
            <span class="ms-2 text-decoration-line-through">Task 2</span>
          </div>
          <div>
            <button class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </li>
        <li
          class="list-group-item d-flex justify-content-between align-items-center"
        >
          <div>
            <button class="btn btn-sm btn-light">
              <i class="bi bi-square"></i>
            </button>
            <span class="ms-2 text-decoration-line-through">Task 3</span>
          </div>
          <div>
            <button class="btn btn-sm btn-danger">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </li> -->
      </ul>
      <div class="mt-4">
        <form class="d-flex justify-content-between align-items-center" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>">
          <input
            type="text"
            class="form-control"
            name="addtask"
            placeholder="Add new item..."
            required
          />
          <input type="hidden" name="action" value="add">
          <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
        </form>
      </div>
    </div>
  </div>
  <!-- <script>
     let check = document.getElementById('checked');
     let list = document.getElementById('deco');
     check.onclick=function(e){
      alert('1');
      console.log(list)
       if(check.checked) {list.style.text-decoration = 'line-through'}
       else if(!check.checked) {list.style.text-decoration = 'none'}
     }
  </script> -->

  <script>
  <!-- <script>
      let checks = document.getElementsByClassName("check");
      for(let check of checks){
          check.onclick=function(e){
            e.target.parentElement.submit()
          }
      }
  </script>
  </script> -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"
  ></script>
</body>
</html>