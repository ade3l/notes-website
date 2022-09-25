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

            // wrong_date will contain date in the local browser timezone.
            //  But the time will be wrong because server returns time in UTC
            wrong_date = new Date(object.date);

            //Now we change the timezone of the date to UTC
            date = new Date(Date.UTC(wrong_date.getFullYear(), wrong_date.getMonth(), wrong_date.getDate(), wrong_date.getHours(), wrong_date.getMinutes(), wrong_date.getSeconds()));

            dateOptions = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' }
            document.querySelector(".noteTop .updated").innerText = date.toLocaleString(undefined,dateOptions);
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
    //Confirm if the user wants to delete the note
    if(confirm("Are you sure you want to delete this note?")){
        note_id = document.querySelector("#note_id").value;
        saveRequest = new XMLHttpRequest();
        saveRequest.open("POST","./scripts/modifyNote.php")
        saveRequest.setRequestHeader("Content-type","application/json")
        saveRequest.send(JSON.stringify({action:"delete",id:note_id}));
        saveRequest.onload = ()=>{
            if(saveRequest.responseText == "success"){
                location.reload();
            }
        }
    }
})
changed = true;
document.querySelector("#saveNote").addEventListener("click",()=>{
    note_id = document.querySelector("#note_id").value;
    if(changed){
        note_title = document.querySelector(".noteTop .title").innerText;
        note_text = document.querySelector(".noteText").innerText;
        note_tags = [];
        document.querySelectorAll(".noteTop .tags .tag").forEach(tag=>{
            note_tags.push(tag.innerText);
        })
        saveRequest = new XMLHttpRequest();
        saveRequest.open("POST","./scripts/modifyNote.php");
        saveRequest.setRequestHeader("Content-type","application/json")
        //Stringify all of the data to send it to the server
        saveRequest.send(JSON.stringify({action:"save",id:note_id,title:note_title,note:note_text,tags:note_tags, date:Date.now()}));
        // console.log(JSON.stringify({action:"save",id:note_id,title:note_title,note:note_text,tags:note_tags,email:email}));
        saveRequest.onload = ()=>{
            if(saveRequest.responseText == "success"){
                location.reload();
            }
            else{

            }
        }
    }
})

document.querySelector("#newNote").addEventListener("click",()=>{
    newNoteRequest = new XMLHttpRequest();
    newNoteRequest.open("POST","./scripts/createNote.php");
    newNoteRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    newNoteRequest.send();
    newNoteRequest.onload = ()=>{
        if(newNoteRequest.responseText == "success"){
            location.reload();
        }
    }
})