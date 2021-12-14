<?php

?>
<script>
        /*window.onload = function() {

        let images = document.getElementsByClassName('card-animal');

        for(let i = 0; i < images.length; i++) (async function(childNode1) {
            if(childNode1) {
            console.log("hey");
            const response = await fetch('https://api.thedogapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1');
            const names = await response.json();
            childNode1.src = names[0].url;
            }
        })(images[i].childNodes[1]);
    };*/



    let data = <?php  echo json_encode(array_values($animaux), JSON_HEX_TAG); ?>;
    console.log(data.length);
    let index = 0;
    let increment = 10;
    async function plus(){
        /*let page = data.splice(index, increment);*/
        let scroller = document.getElementById("a-scroller");
        if(index+increment >= data.length){
            increment = (data.length - index);
            document.getElementById("plus").remove();
        }
        let i = index;
        for(; i < index+increment; i++){
            let elem = data[i];
            let esp = await get_photo(elem["e_nom"]);
            scroller.innerHTML += `<a href="" class="ref-link" espece="${elem["e_nom"]}">
                                        <div class="card card-animal" style="width: 18rem;">
                                          <img src="${esp}" class="card-img-top" alt="">
                                          <div class="card-body">
                                            <p class="card-text text-lg-center">
                                            ${elem["a_nom"]}

                                            </p>
                                          </div>
                                        </div>
                                    </a> `;
        }
        /*location.hash = "plus"*/
        /*if((index+increment % data.length) == 0){
            document.getElementById("plus").remove();
        }*/
        index += increment;

    }
    async function get_photo(espece) {
        let url = "";
        switch (espece) {
            case "Chat":
                const dchat = await fetch('https://api.thecatapi.com/v1/images/search',
                    {
                        headers:{
                            "x-api-key":"119807ac-4796-4ddd-90ae-0b415cb647b9",
                            "mime_types": "png,jpg"
                        }
                    }
                );
                url = await dchat.json();
                url = url[0].url;
                break;
            case "Chien":
                const dchien = await fetch('https://api.thedogapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1');
                const data = await dchien.json();
                url = await data[0].url;
                break;
            case "Equidé":
                url = "https://www.freeiconspng.com/uploads/horse-icon-15.png";
                break;
            case "Lapin":
                url = "https://iconarchive.com/download/i107114/roundicons/100-free-solid/rabbit.ico";
                break;
            case "Porcin":
                url = "https://i.pinimg.com/736x/32/72/a0/3272a0a388fac987c43bd5f1a8401c79--pig-tattoos-symbols-of-strength.jpg";
                break;
            case "Bovin":
                url = "https://media.istockphoto.com/vectors/cow-head-vector-id1284029657?k=20&m=1284029657&s=170667a&w=0&h=EJUuIqa2CHunBYDiPplx24mQasrZ5RYeasHDAT3C3Ao=";
                break;
            case "Ovin":
                url = "https://images.vexels.com/media/users/3/162443/isolated/lists/91d333ac6f9aeb94c39f72fe7bf685c9-sheep-wool-lamb-hoof-flat-rounded-geometric.png";
                break;
            case "Caprin":
                url = "http://pngimg.com/uploads/capricorn/small/capricorn_PNG6.png";
                break;
            case "Mustélidés":
                url = "https://media.istockphoto.com/vectors/silhouette-of-a-sitting-otter-vector-id675402914?k=20&m=675402914&s=612x612&w=0&h=PzxYogYAyWv4c8QPxqilhAxrI7h1_yL35LXqFhvO0uE=";
                break;
            case "Rongeur":
                url = "https://1001symboles.net/images/souris.jpg";
                break;
            case "Camelidé":
                url = "https://cdn-icons-png.flaticon.com/512/2055/2055537.png";
                break;
            default:
                url = "";
        }
        return url;
    }

    plus();


</script>