notes = document.querySelectorAll(".note")
notes.forEach(note=>{
    note.addEventListener("click",()=>{
        noteRequest = new XMLHttpRequest();
        noteRequest.open("POST","./scripts/fetchNote.php");
        noteRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        noteRequest.send("note_id="+note.getAttribute("data-key"));
        noteRequest.onload = ()=>{
            object = JSON.parse(noteRequest.responseText);
            document.querySelector(".noteTop .title").innerText = object.title;
            document.querySelector(".noteText").innerText = object.note;           
        }
    })
})