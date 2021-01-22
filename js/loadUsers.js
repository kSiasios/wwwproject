$(document).ready(function () {
  var limit = 4;
  $("#loadUsers").click(function () {
    $("#users").load("/Project2/includes/loadUsers.php", {
      newlimit: limit,
    });
    limit = limit + 2;
  });
});
