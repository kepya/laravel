//declaring html elements 

//profil-pic
const imgDiv = document.querySelector(".profile-pic-div");
const img = document.querySelector("#photo");
const file = document.querySelector("#file");
const uploadBtn = document.querySelector("#uploadBtn");

//facture
const facture1 = document.querySelector(".facture-1");
const facture2 = document.querySelector(".facture-2");
const facture3 = document.querySelector(".facture-3");
const btninfo1 = document.querySelector(".btn-1-facture");
const btninfo2 = document.querySelector(".btn-2-facture");
const btninfo3 = document.querySelector(".btn-3-facture");
const details1 = document.querySelector(".details-facture-1");
const details2 = document.querySelector(".details-facture-2");
const details3 = document.querySelector(".details-facture-3");
const close1 = document.querySelector(".btn-facture-1-close");
const close2 = document.querySelector(".btn-facture-2-close");
const close3 = document.querySelector(".btn-facture-3-close");

//facture devices width under 660px
const btnsminfo1 = document.querySelector(".facture-bloc-text .btn-fac-1-sec");
const btnsminfo2 = document.querySelector(".facture-bloc-text .btn-fac-2-sec");
const btnsminfo3 = document.querySelector(".facture-bloc-text .btn-fac-3-sec");
const closesm1 = document.querySelector(".details-facture-bloc-text .btn-fac-1-close");
const closesm2 = document.querySelector(".details-facture-bloc-text .btn-fac-2-close");
const closesm3 = document.querySelector(".details-facture-bloc-text .btn-fac-3-close");

//if user hover on img div
imgDiv.addEventListener('mouseenter', function(){
    uploadBtn.style.display = "block";
});

//if he hover out img div
imgDiv.addEventListener('mouseleave', function(){
    uploadBtn.style.display = "none";
});

//functionnalities 

//when we choose a file to upload

file.addEventListener('change', function(){
    //this refers to file
    const choosedFile = this.files[0];

    if(choosedFile){
        const reader = new FileReader();

        reader.addEventListener('load', function(){
            img.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});

//coding the bills' part

btninfo1.addEventListener('click', function(){

    facture1.style.display="none";
    details1.style.display="block";

});

btnsminfo1.addEventListener('click', function(){

    facture1.style.display="none";
    details1.style.display="block";

});

btninfo2.addEventListener('click', function(){
    
    facture2.style.display="none";
    details2.style.display="block";
});

btnsminfo2.addEventListener('click', function(){
    
    facture2.style.display="none";
    details2.style.display="block";
});

btninfo3.addEventListener('click', function(){

    facture3.style.display="none";
    details3.style.display="block"; 
});

btnsminfo3.addEventListener('click', function(){

    facture3.style.display="none";
    details3.style.display="block"; 
});

close1.addEventListener('click', function(){

    facture1.style.display="block";
    details1.style.display="none";

});

closesm1.addEventListener('click', function(){

    facture1.style.display="block";
    details1.style.display="none";

});

close2.addEventListener('click', function(){

    facture2.style.display="block";
    details2.style.display="none";

});

closesm2.addEventListener('click', function(){

    facture2.style.display="block";
    details2.style.display="none";

});

close3.addEventListener('click', function(){

    facture3.style.display="block";
    details3.style.display="none";

});

closesm3.addEventListener('click', function(){

    facture3.style.display="block";
    details3.style.display="none";

});


