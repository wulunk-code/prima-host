
document.addEventListener('DOMContentLoaded',function(){

document.querySelectorAll('.prima-cart-form').forEach(function(form){

form.addEventListener('submit',async function(e){

e.preventDefault();

const button=form.querySelector('button');

if(button.disabled)return;

button.disabled=true;

const oldText=button.innerHTML;
button.innerHTML='⏳ Menambahkan...';

try{

const response=await fetch(form.action,{
method:'POST',
body:new FormData(form),
headers:{
'Accept':'application/json',
'X-Requested-With':'XMLHttpRequest'
},
credentials:'same-origin'
});

if(!response.ok){
throw new Error('Gagal menambahkan produk');
}

showToast('✅ Produk berhasil ditambahkan');

const badge=document.querySelector('.cart-badge');

if(badge){
let count=parseInt(badge.textContent)||0;
badge.textContent=count+1;
}

}catch(error){

showToast('❌ Gagal menambahkan produk');

}finally{

button.disabled=false;
button.innerHTML=oldText;

}

});

});

function showToast(message){

const old=document.querySelector('.prima-cart-toast');
if(old)old.remove();

const toast=document.createElement('div');
toast.className='prima-cart-toast';
toast.textContent=message;

document.body.appendChild(toast);

setTimeout(function(){
toast.remove();
},2500);

}

});

