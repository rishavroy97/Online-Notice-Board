function ToggleDisplay(id1, id2, button1, button2) {
    var x = document.getElementById(id1);
    var y = document.getElementById(id2);
    var a = document.getElementById(button1);
    var b = document.getElementById(button2);
    
    if (x.style.display === 'block') {
    	return;
    }
    else{
        x.style.display = 'block';
        y.style.display = 'none';
        a.classList.toggle("active");
    	b.classList.toggle("active");
    }
}

var para = document.getElementsByClassName('View');
for (i = 0; i < para.length; i++) {
  para[i].style.display = 'none';
}


var caption = document.getElementsByClassName("Topic");
var i;
for (i = 0; i < caption.length; i++) {
  caption[i].onclick = function() {
    if(this.parentNode.lastElementChild.style.display === "none"){
        this.parentNode.lastElementChild.style.display = "block";
    }
    else{
      this.parentNode.lastElementChild.style.display = "none";
    }
    this.classList.toggle('Topic');
    this.classList.toggle('ActiveListView');
  }
}


//for deleting notes
/*var removed_subject = "";
var removed_note = "";
var remove = function(){
    removed_subject = this.parentNode.parentNode.childNodes[0].innerHTML;
    removed_note = this.parentNode.parentNode.childNodes[1].innerHTML;
    this.parentNode.parentNode.remove();
    console.log(removed_subject);
    console.log(removed_note);
    //window.location.href = "delete_notes.php?subject=" + removed_subject + "&note=" + removed_note;
};
*/
/*var subject = document.getElementsByClassName("delSub");

/*for (var i = 0, len = subject.length; i < len; i++) {
    subject[i].addEventListener('click', remove);
    //subject[i].addEventListener('click',);
}*/
