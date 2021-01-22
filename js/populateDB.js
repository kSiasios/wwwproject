$(document).ready(function () {
  var initialized = 0;
  $("#init-btn").click(function () {
    fetchData();
    console.log("Clicked!");
  });

  $("#flush-btn").click(function () {
    var obj = {
      table: [],
    };

    var json = JSON.stringify(obj);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "/Project2/includes/flushDB.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(json);
    console.log("Clicked!");
  });
});

function fetchData() {
  const fp = fetch("https://randomuser.me/api/?results=10");

  fp.then((response) => {
    return response.json();
  })
    .then((people) => {
      jsonData(people);
    })
    .catch((e) => {
      console.log(e);
    });
}

function jsonData(people) {
  var obj = {
    table: [],
  };
  people.results.forEach((person) => {
    obj.table.push({
      un: person.name.first + person.name.last,
      em: person.email,
      img: person.picture.large,
    });
  });

  var json = JSON.stringify(obj);

  var xhr = new XMLHttpRequest();

  xhr.open("POST", "/Project2/includes/initDB.php");
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.send(json);
}
