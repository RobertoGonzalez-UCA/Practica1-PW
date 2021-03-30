function JSfunction(){
    const $btnSelect = document.getElementById("rol").value;

    if($btnSelect == "alumno"){
        const $title = document.getElementById("id-subjects").innerHTML = "Matriculado en: "; 
        const $subjectsBlock = document.getElementById("subjects-block");  

        $subjectsBlock.style.visibility = "visible"; 
    }else if($btnSelect == "profesor"){
        const $title = document.getElementById("id-subjects").innerHTML = "Imparte: ";
        const $subjectsBlock = document.getElementById("subjects-block");  

        $subjectsBlock.style.visibility = "visible";  
    }else if($btnSelect == "admin"){
        const $title = document.getElementById("id-subjects").innerHTML = "";
        const $subjectsBlock = document.getElementById("subjects-block");  
        $subjectsBlock.style.visibility = "hidden";
    }
}