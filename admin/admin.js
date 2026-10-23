// Pencarian tabel
document.querySelectorAll('[data-search]').forEach(s=>s.oninput=()=>{const q=s.value.toLowerCase();
 s.parentElement.querySelectorAll('tbody tr').forEach(r=>r.style.display=r.textContent.toLowerCase().includes(q)?'':'none')});
// Preview gambar dari URL
document.querySelectorAll('[data-preview]').forEach(inp=>{const img=document.createElement('img');img.className='preview';
 const up=()=>{img.src=inp.value;img.style.display=inp.value?'block':'none'};inp.after(img);inp.oninput=up;up()});
