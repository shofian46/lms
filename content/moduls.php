<?php
$id_user = isset($_SESSION['uuid']) ? $_SESSION['uuid'] : null;
$id_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$rowstudent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id='$id_user'"));

$id_major = isset($rowstudent) ? $rowstudent['id_major'] : null;
$id_user = isset($_SESSION['uuid']) ? $_SESSION['uuid'] : '';

if ($id_role == 2) {
  $where = "WHERE modules.id_major='$id_major'";
} elseif ($id_role == 1) {
  $where = "WHERE modules.id_instructor='$id_user'";
}
$query = mysqli_query($conn, "SELECT majors.name as major_name,
instructors.name as instructor_name, modules.* 
FROM modules
LEFT JOIN majors ON majors.id = modules.id_majors
LEFT JOIN instructors ON instructors.id = modules.id_instructor WHERE modules.id_instructor = '$id_user'
ORDER BY modules.id DESC");
// 12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Data Modul</h5>
        <?php if (canAddModul(1)): ?>
          <div class="mb-3" align="right">
            <a href="?page=tambah-modul" class="btn btn-primary">Add Modul</a>
          </div>
        <?php endif; ?>
        <div class="table-responsive">
          <table class="table table-bordered datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Instructor</th>
                <th>Major</th>
                <th>Title</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $index => $row): ?>
                <tr>
                  <td><?php echo $index += 1; ?></td>
                  <td><a href="?page=tambah-modul&detail=<?= $row['id']; ?>"><?php echo $row['instructor_name'] ?></a></td>
                  <td><?php echo $row['major_name'] ?></td>
                  <td><?php echo $row['name'] ?></td>
                  <td>
                    <a onclick="return confirm('Are you sure wanna delete this data??')"
                      href="?page=tambah-modul&delete=<?php echo $row['id'] ?>"
                      class="btn btn-danger">Delete</a>

                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>