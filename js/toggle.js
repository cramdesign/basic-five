var toggleClass = function(el, className) {
 
    if (el.classList) {
    
        el.classList.toggle(className);
        
    } else {
    
        var classes       = el.className.split(' '),
            existingIndex = classes.indexOf(className);
 
        if (existingIndex >= 0) {
            classes.splice(existingIndex, 1);
        }else {
            classes.push(className);
        }
 
        el.className = classes.join(' ');
        
    }

};

var btn = document.getElementById('menu');

btn.onclick = function () {
    toggleClass(this, 'open');
}