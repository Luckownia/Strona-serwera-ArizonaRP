       
                                //LANDING-PAGE
       
       //Change light-mode
            const inputCheckbox = document.querySelector(".switch-mode-checkbox");
            const circleImage = document.querySelector(".circle-image")
            const logoPalm = document.querySelector(".logo img");

            //Hovering cursor on elements
            const turnOnButton = document.querySelector(".turn-on");
            const turnOffButton = document.querySelector(".turn-off");
            const headline = document.querySelector(".headline");
            const subHeadline = document.querySelector(".sub-headline");
            const logo = document.querySelector(".logo");
            const navLabel = document.querySelector("label");
            const cursor = document.querySelector(".mouse");
            

            const animateCursor = ()=>{
                 cursor.classList.add("cursor-animate");
            }

            const removeAnimateCursor = ()=>{
                 cursor.classList.remove("cursor-animate");
            }
            headline.addEventListener("mouseenter",animateCursor)
            headline.addEventListener("mouseleave",removeAnimateCursor)
            subHeadline.addEventListener("mouseenter",animateCursor)
            subHeadline.addEventListener("mouseleave",removeAnimateCursor)
            logo.addEventListener("mouseenter",animateCursor)
            logo.addEventListener("mouseleave",removeAnimateCursor)
            navLabel.addEventListener("mouseenter",animateCursor)
            navLabel.addEventListener("mouseleave",removeAnimateCursor)
            turnOnButton.addEventListener("mouseenter",animateCursor); 
            turnOnButton.addEventListener("mouseleave",removeAnimateCursor);
            turnOffButton.addEventListener("mouseenter",animateCursor);
            turnOffButton.addEventListener("mouseleave",removeAnimateCursor);

           // Cursor
            window.addEventListener("mousemove",(e)=>{
                let x = e.clientX;
                let y = e.clientY;
                cursor.style.top = y ;
                cursor.style.left = x ;
            });

            // MOBILNY BURGER
             const hamburger = document.querySelector(".hamburger");
              const navigation = document.querySelector(".navigation");
              const lines = document.querySelectorAll(".line");
                 hamburger.addEventListener("click",()=>{    
                    navigation.classList.toggle("wrap");
                    hamburger.classList.toggle("vidmo");
              }) 

            // Focus state of nav-links

            const navLinks = document.querySelectorAll(".nav-link");
           
            navLinks.forEach(link => {

                link.addEventListener("click", () => {
                    navLinks.forEach(link1 => {
                        if (link1.classList.contains('active')) {
                            link1.classList.remove('active');
                        }
                    })
                    link.classList.add("active");
                })

               link.addEventListener("mouseenter",animateCursor)
                link.addEventListener("mouseleave",removeAnimateCursor)
            })
             //Button More's hover
            const btnMore = document.querySelector(".btn-more");
            btnMore.addEventListener("mouseenter", (e) => {
                let x = e.clientX - e.target.offsetLeft;
                let y = e.clientY - e.target.offsetTop;
                let ripples = document.createElement("span");
                ripples.classList.add("ripples");
                ripples.style.left = x + "px";
                ripples.style.top = y + "px";
                btnMore.appendChild(ripples);
                if (circleImage.src.endsWith("moon.png")) {
                        ripples.style.backgroundColor="white";
                }
               cursor.style.display = 'none';
                setTimeout(() => {
                    ripples.remove()
                }, 1000);
            })

             btnMore.addEventListener("mouseleave",()=>{
                 cursor.style.display = 'block';
             })


            // LANDING PAGE -2

            
            const photo = document.querySelector(".logo img");
            const circle = document.querySelector(".span-circle");
            const sectionFrist = document.querySelector(".feature-1");
            const sectionSec = document.querySelector(".feature-2");
            const sectionThr = document.querySelector(".feature-3");
            const sectionFor = document.querySelector(".feature-4");
            const sekcjaFor = document.querySelector("#section-4");
            const switchModeAll = document.querySelectorAll(".switch-mode-checkbox");
            const currentTheme = localStorage.getItem("theme");
            let theme = "dark";
            inputCheckbox.addEventListener("click", function(){
                document.body.classList.toggle("darkmode");
                //circle.classList.toggle("span-transform");
                if(inputCheckbox.value=="on"){
                if(circleImage.src.endsWith("sun.png")){
                    circleImage.src = "img/moon.png";
                    photo.src =  "img/blackpalm.png";
                    theme = "dark"
                }
                    else if(circleImage.src.endsWith("moon.png")){
                    circleImage.src = "img/sun.png";
                    photo.src =  "img/palm-tree-48.png";
                    theme = "light"
                }
                }
                localStorage.setItem("theme", theme);
            })
            function themechange(){
                if(currentTheme == "dark"){
                    document.body.classList.add("darkmode");
                    //circle.classList.add("span-transform");
                    circleImage.src = "img/moon.png";
                    photo.src =  "img/palm-tree-48.png";
                    theme = "dark"
            }
            else if(currentTheme =="light"){
                document.body.classList.remove("darkmode");
               // circle.classList.remove("span-transform");
                        circleImage.src = "img/sun.png";
                    photo.src =  "img/blackpalm.png";
                    theme = "light"
            }
            }
            themechange();
            console.log(sectionSec.offsetTop);

            window.addEventListener("scroll", function(){
                console.log(window.scrollY);
                if(window.scrollY>sectionFrist.offsetTop)
                {
                    sectionFrist.classList.add("left-side");
                }
               if (window.scrollY> sectionSec.offsetTop+1000) {
                     sectionSec.classList.add("right-side");
                      
                }
               if (window.scrollY > sekcjaFor.offsetTop - 500) {
                            sectionFor.classList.add("right-side");
                        
                        }
                 if(window.scrollY > sectionThr.offsetTop + 1900) {
                    sectionThr.classList.add("left-side");
    
                }
            })
           

            /*const navList = document.querySelectorAll(".navlink")
            navList.forEach(li => {
                li.addEventListener("click", function(){
                    navList.forEach(link => {
                        if (link.classList.contains("active")){
                        link.classList.remove("active");
                    }
                    })
                    li.classList.add("active");
                })
            })
            */
            const button1 = document.querySelector(".btn-join");
            const step1 = document.querySelector(".step-1");
            const step2 = document.querySelector(".step-2");
            const layer = document.querySelector(".layer");
            const button2 = document.querySelector(".step-1 .btn-join");
            const button3 = document.querySelector(".step-2 .btn-join");
            const button5 = document.querySelector(".done-span-1");
            const button6 = document.querySelector(".done-span-2");
            button2.addEventListener("click", function(){
                step2.style.right=0;
            })
            button3.addEventListener("click", function(){
                layer.style.visibility="hidden";
                step1.classList.remove("move1");
                step2.style.right=-100+"%";
            })
            function klikniecie(){
            step1.classList.add("move1");
            layer.style.visibility="visible";
            }
            button5.addEventListener("click", function(){
                step2.style.right=0;
            })
            button6.addEventListener("click", function(){
                layer.style.visibility="hidden";
                step1.classList.remove("move1");
                step2.style.right=-100+"%";
            })
           /* const headline = document.querySelector(".headline");
            const paragraph = document.querySelector(".paragraph");
            addEventListener("load", function(){
                headline.classList.add("headline-efekt");

            })*/

