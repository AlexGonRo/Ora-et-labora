
// Protect email addresses from crawlers
// Effective method according to http://www.grall.name/posts/1/antiSpam-emailAddressObfuscation.html
// I also took their code and made some small changes!!!

function ROT13(a) {
  // ROT13 : a Caesar cipher 
  return a.replace(/[a-zA-Z]/g, function(c){
    return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
  });
}; 

function decipher_mail(element, event) {
  var y = ROT13("nqzvavfgenqbe@benoben.arg");
  element.setAttribute("href", "#");
  element.setAttribute("onclick", "");
  element.firstChild.nodeValue = y;
  event.preventDefault();
};

