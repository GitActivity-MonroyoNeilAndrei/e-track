
function onlyTwoCheckBox(div_id) {
  var limit = 1;
  if(div_id == 'PIO' ||
     div_id == 'Project Manager' ||
     div_id == 'Sargeant at Arms') 
  {
    limit = 2;
  }

  console.log(limit);

  // gets the 2 inputs on/off
  var checkboxgroup = document.getElementById(div_id).getElementsByTagName("input");
  // for loop to iterate to the inputs, in our case just 2 inputs
  for (var i = 0; i < checkboxgroup.length; i++) {
    checkboxgroup[i].onclick = function() {
      var checkedcount = 0;
      // increment the value of checkedcount if we check something in the checkbox input
      for (var i = 0; i < checkboxgroup.length; i++) {
        checkedcount += (checkboxgroup[i].checked) ? 1 : 0;
      }
      // if the limit is reach, we must throw an alert message saying that the user reach their limit checks
      if (checkedcount > limit) {
        console.log("You can select maximum of " + limit);
        alert("You can select maximum of " + limit );
        this.checked = false;
      }
    }
  }
}