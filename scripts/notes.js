notes = document.querySelectorAll(".note")
email = document.querySelector("#email").value
console.log(email);
notes.forEach(note=>{
    note.addEventListener("click",()=>{
        noteRequest = new XMLHttpRequest();
        noteRequest.open("POST","./scripts/fetchNote.php");
        noteRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        noteRequest.send("note_id="+note.getAttribute("data-key")+ "&email="+email);
        noteRequest.onload = ()=>{
            object = JSON.parse(noteRequest.responseText);
            document.querySelector(".noteTop .title").innerText = object.title;
            document.querySelector(".noteTop .updated").innerText = object.date;
            document.querySelector(".noteText").innerText = object.note;
            // parse tags and add them to the tag list
            // tags will be an array parsed from object.tags
            tags = JSON.parse(object.tags);
            tagsContainer = document.querySelector(".noteTop .tags");
            tagsContainer.innerText = "";
            if(tags!=null){
                tags.forEach(tag=>{
                    tagElement = document.createElement("span");
                    tagElement.classList.add("tag");
                    tagElement.innerText = tag;
                    tagsContainer.appendChild(tagElement);
                })
            }
            //Set the note id in the hidden field
            document.querySelector("#note_id").value = object.id;
        }
    })
})

document.querySelector("#deleteNote").addEventListener("click",()=>{
    note_id = document.querySelector("#note_id").value;
    saveRequest = new XMLHttpRequest();
    saveRequest.open("POST","./scripts/modifyNote.php")
    saveRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded")
    saveRequest.send("action=delete"+"&id="+note_id+"&email="+email);
    saveRequest.onload = ()=>{
        if(saveRequest.responseText == "success"){
            location.reload();
        }
    }
})