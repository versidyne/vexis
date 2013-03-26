/* Message Box */
function MsgBox (textstring) { alert (textstring); }

/* AutoTab Script  */
var isNN = (navigator.appName.indexOf("Netscape")!=-1);

function autoTab(input,len, e) {
  var keyCode = (isNN) ? e.which : e.keyCode; 
  var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
  if(input.value.length >= len && !containsElement(filter,keyCode)) {
    input.value = input.value.slice(0, len);
    input.form[(getIndex(input)+1) % input.form.length].focus();
  }

  function containsElement(arr, ele) {
    var found = false, index = 0;
    while(!found && index < arr.length)
    if(arr[index] == ele)
    found = true;
    else
    index++;
    return found;
  }

  function getIndex(input) {
    var index = -1, i = 0, found = false;
    while (i < input.form.length && index == -1)
    if (input.form[i] == input)index = i;
    else i++;
    return index;
  }
  return true;
}

/* Caps Lock Detection */
function CapsDetect( e ) {
  //if the browser did not pass event information to the handler,
  //check in window.event
  if( !e ) { e = window.event; } if( !e ) { return; }
  //what (case sensitive in good browsers) key was pressed
  //this uses all three techniques for checking, just in case
  var theKey = 0;
  if( e.which ) { theKey = e.which; } //Netscape 4+, etc.
  else if( e.keyCode ) { theKey = e.keyCode; } //Internet Explorer, etc.
  else if( e.charCode ) { theKey = e.charCode } //Gecko - probably not needed
  //was the shift key was pressed
  var theShift = false;
  if( e.shiftKey ) { theShift = e.shiftKey; } //Internet Explorer, etc.
  else if( e.modifiers ) { //Netscape 4
    //check the third bit of the modifiers value (says if SHIFT is pressed)
    if( e.modifiers & 4 ) { //bitwise AND
      theShift = true;
    }
  }
  //if upper case, check if shift is not pressed
  if( theKey > 64 && theKey < 91 && !theShift ) {
    alert( 'Caps Lock is engaged.' );
  }
  //if lower case, check if shift is pressed
  else if( theKey > 96 && theKey < 123 && theShift ) {
    alert( 'Caps Lock is engaged.' );
  }
}

/* Count Characters */
function countCharacters(textArea, counterField, maxLength){		
	if(textArea !=null && textArea.value != null) {
		if (textArea.value.length > maxLength){
			alert("Your message may not exceed " +  maxLength +" characters in length.");
			textArea.value = textArea.value.substring( 0, maxLength);
		} else {
			counterField.value = maxLength - textArea.value.length;
		}
	}
}

/* Required Fields */
function checkrequired(which) {
  var pass=true;
  for (i=0;i<which.length;i++) {
    var tempobj=which.elements[i];
	/* tempobj.name */
    if (tempobj.name.substring(0,8)=="required") {
      if (((tempobj.type=="text"||tempobj.type=="textarea")&&
          tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&&
          tempobj.selectedIndex==0)) {
        pass=false;
        break;
      }
    }
  }
  if (!pass) {
    /* shortFieldName=tempobj.name.substring(8,30).toUpperCase(); */
	shortFieldName=tempobj.name.substring(0,30);
    alert("The "+shortFieldName+" field is a required field.");
    return false;
  } else {
  return true;
  }
}
