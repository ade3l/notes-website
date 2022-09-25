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
        }
    })
})