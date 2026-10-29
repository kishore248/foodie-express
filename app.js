// Unit II: JavaScript - functions, variables, DOM, events, loops, CSS manipulation
function filterMenu() {
  var text = document.getElementById('searchBox').value.toLowerCase();
  var cat = document.getElementById('activeCat').value;
  var cards = document.getElementsByClassName('menu-col');
  for (var i = 0; i < cards.length; i++) {
    var name = cards[i].getAttribute('data-name').toLowerCase();
    var c = cards[i].getAttribute('data-cat');
    var show = name.indexOf(text) !== -1 && (cat === 'All' || cat === c);
    cards[i].style.display = show ? 'block' : 'none';
  }
}
function setCategory(btn, cat) {
  document.getElementById('activeCat').value = cat;
  var btns = document.querySelectorAll('.filter-btn');
  for (var i = 0; i < btns.length; i++) btns[i].classList.remove('active');
  btn.classList.add('active');
  filterMenu();
}
function updateSubtotal(sel, price, id) {            // onchange event
  document.getElementById('sub' + id).textContent = '₹' + (sel.value * price);
}
function highlight(el) { el.style.borderColor = '#dc3545'; }     // onmouseover
function unhighlight(el) { el.style.borderColor = '#f1d4c0'; }   // onmouseout
function validateRegister() {
  var f = document.forms['regForm'];
  if (!/^[0-9]{10}$/.test(f['phone'].value)) { alert('Enter a 10-digit phone number'); return false; }
  if (f['password'].value.length < 6) { alert('Password must be at least 6 characters'); return false; }
  return true;
}
function validateCheckout() {
  var f = document.forms['checkoutForm'];
  if (f['address'].value.trim().length < 10) { alert('Please enter a full delivery address'); return false; }
  if (!f['terms'].checked) { alert('Please accept the terms'); return false; }
  return true;
}
function payChange(radio) {
  var box = document.getElementById('upiBox');
  if (box) box.style.display = (radio.value === 'UPI') ? 'block' : 'none';
}
function drawChart(labels, values) {                 // Canvas and drawing
  var c = document.getElementById('statusChart');
  if (!c) return;
  var ctx = c.getContext('2d'), max = Math.max.apply(null, values.concat([1]));
  var colors = ['#6c757d', '#ffc107', '#0d6efd', '#198754'];
  for (var i = 0; i < labels.length; i++) {
    var h = (values[i] / max) * 150, x = 40 + i * 90;
    ctx.fillStyle = colors[i]; ctx.fillRect(x, 190 - h, 60, h);
    ctx.fillStyle = '#000'; ctx.font = '12px Arial';
    ctx.fillText(values[i], x + 25, 185 - h);
    ctx.fillText(labels[i].substring(0, 10), x, 210);
  }
}
