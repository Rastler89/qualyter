<html>
    <head>
        <style>
             *, *:before, *:after {
                box-sizing: border-box;
            }
            body, html {
                background-color: #2c1b35;
            }
            .table {
                display: table;
                width: 100%;
                top: 10px;
                position: absolute;
                height: 100%;
            }
            .table-cell {
                display: table-cell;
                vertical-align: middle;
            }
            #decoration, #decoration2, #decoration3 {
                position: absolute;
                background-color: yellow;
                width: 420px;
                height: 70px;
                opacity: 0;
                border-radius: 10px;
            }
            #decoration2 {
                background-color: magenta;
            }
            #decoration3 {
                background-color: cyan;
            }
            .leader {
                list-style-type: none;
                padding: 0;
                margin: 0 auto;
                width: 90vw;
            }
            .leader li {
                background-color: #fff;
                border-radius: 5px;
                height: 100px;
                margin-bottom: 10px;
                overflow: hidden;
                box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            }
            .leader li .list_num {
                float: left;
                line-height: 40px;
                font-size: 2em;
                color: rgba(0, 0, 0, 0.65);
                vertical-align: middle;
                margin: 25px;
                font-weight: bold;
                width: 20px;
                text-align: right;
                margin-left: 20px;
            }
            .leader li h2 {
                display: block;
                margin: 0;
                text-align: center;
                font-size: 2em;
                line-height: 40px;
                font-weight: 300;
                margin-top: 25px;
                padding-right: 20px;
            }
            .leader li h2 .number {
                float: right;
                font-weight: bold;
                color: rgba(0, 0, 0, 0.65);
                transition: color 0.3s;
            }
            .leader li img {
                width: 100px;
                height: 100px;
                float: left;
                margin-left: 0;
            } 
            .loader {
                top: 25vh;
                left: 50vw;
                position: absolute;
                visibility: hidden;
                width: 150px;
                height: 150px;
                border: 3px dotted #FFF;
                border-style: solid solid dotted dotted;
                border-radius: 50%;
                display: inline-block;
                position: relative;
                box-sizing: border-box;
                animation: rotation 2s linear infinite;
            }
            .loader::after {
                content: '';  
                box-sizing: border-box;
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                margin: auto;
                border: 3px dotted #FF3D00;
                border-style: solid solid dotted;
                width: 75px;
                height: 75px;
                border-radius: 50%;
                animation: rotationBack 1s linear infinite;
                transform-origin: center center;
            }
                
            @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
            } 
            @keyframes rotationBack {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(-360deg);
            }
            } 
        </style>
    </head>
    <body>
    <div class="loader" id="loader"></div>
    <div class="table" id="leaderboard">
        <div class="table-cell">
            <ul class="leader">
            <div id="decoration"></div>
            <div id="decoration2"></div>
            <div id="decoration3"></div>
            @foreach($agents as $agent)
            <li id="{{$agent->id}}">
                <span class="list_num">{{$loop->index}}</span>
                <img src="{{asset($agent->image)}}" />
                <h2>{{$agent->name}}<span class="number"></span></h2>
            </li>
            @endforeach
            </ul>
        </div>
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
        <script>
            // ----- On render -----
            var green = "#3CC796";
            var black = "rgba(0,0,0,0.65)";
            var red = "#3CC796";
            var height = 110;
            var up = [];
            var down = [];
            var result = '';

            //  prepare agents
            var agents = <?=json_encode($agents)?>;
            agents.forEach(function(agent,index) {
                agent.position = index;
                agent.old_position = index;
            });
            console.log('una');
            setInterval(init,10000);


            //cambios
            var swappem = function() {  
                document.getElementById('loader').style.visibility='hidden';
                document.getElementById('leaderboard').style.visibility='visible';
                //Sube
                up.forEach(function(agent) {
                    var joel = agent.objeto;
                    TweenMax.to(joel, 0.25, {
                    scale: 1.1,
                    onComplete: function() {
                        joel.find('.list_num').text(agent.position+1);
                        if(agent.position==0) {
                            joel.css('background', '#ffbf00');
                        } else if(agent.position==1) {
                            joel.css('background', 'silver');
                        } else if(agent.position==2) {
                            joel.css('background', '#cd7f32');
                        }

                    }
                    });
                    TweenMax.to(joel, 0.6, {
                        y: -agent.move*height,
                        delay: 0.1
                    })
                    TweenMax.to(joel, 0.5, {
                        scale: 1,
                        delay: 0.6,
                        ease: Elastic.easeOut.config(1, 0.3)
                    })
                })
                //Baja
                down.forEach(function(agent) {
                    var drew = agent.objeto;
                    TweenMax.to(drew, 0.5, {
                        y: agent.move*height,
                        delay: 0.1,
                        onUpdate: function() {
                            drew.find('.list_num').text(agent.position+1);
                        }
                    })
                })

                //Puntuaciones
                /*var numbers = {
                    drew: 5,
                    joel: 1
                };
                TweenMax.to(numbers, 0.667, {
                    drew: 5,
                    joel: 1,
                    onUpdate: function() {
                        var joelNum = Math.floor(numbers.joel).toLocaleString();
                        joel.find('.number').text(joelNum)
                        var drewNum = Math.floor(numbers.drew).toLocaleString();
                        drew.find('.number').text(drewNum)
                    }
                })
                //Animaciones
                TweenMax.to($('#decoration'), 0.12, {
                    y: pos_effect*height,
                    autoAlpha: 1,
                    scaleX: 1.05,
                    scaleY: 1.3,
                    delay: 0.6,
                    ease: Power3.easeOut,
                    onComplete: function() {
                        TweenMax.to($('#decoration'), 0.125, {
                            scale: 0,
                            delay: 0.2,
                            ease: Power3.easeIn
                        })
                    }
                })
                TweenMax.to($('#decoration2'), 0.12, {
                    y: pos_effect*height,
                    autoAlpha: 1,
                    scaleX: 1.05,
                    scaleY: 1.3,
                    delay: 0.65,
                    ease: Power3.easeOut,
                    onComplete: function() {
                        TweenMax.to($('#decoration2'), 0.125, {
                            scale: 0,
                            delay: 0.1,
                            ease: Power3.easeIn
                        })
                    }
                })
                TweenMax.to($('#decoration3'), 0.12, {
                    y: pos_effect*height,
                    autoAlpha: 1,
                    scaleX: 1.05,
                    scaleY: 1.3,
                    delay: 0.7,
                    ease: Power3.easeOut,
                    onComplete: function() {
                        TweenMax.to($('#decoration3'), 0.125, {
                            scale: 0,
                            ease: Power3.easeIn
                        })
                    }
                })*/
            }

            function init() {
                
                $.post('/api/leaderboard',{init:'2022-08-01',finish:'2022-08-31',type:'agent' }, function(res) {
                    res.forEach(function(result,index) {
                        agents.find(function(agent,key) {
                            if(agent.email == result.agent.email) {
                                agent.new_position = index;
                                agent.objeto = $('#'+agent.id);
                                agent2 = agents.find(ag => ag.position == index);
                                if(agent.new_position<agent.position) {
                                    if(agent2==undefined) {
                                        agent.position=index;
                                    } else {
                                        getPosition(agent2.id,agent.id,true);
                                    }
                                    agent.move = agent.old_position - agent.position;
                                    agent.poss_effect = index;
                                    up.push(agent);
                                } else if(agent.new_position>agent.position) {
                                    agent.move = agent.new_position - agent.old_position ;
                                    if(agent2==undefined) {
                                        agent.position=index;
                                    } else {
                                        getPosition(agent.id,agent2.id,false);
                                    }
                                    agent.poss_effect = index;
                                    down.push(agent);
                                }
                            }
                        })
                    })
                    document.getElementById('loader').style.visibility='visible';
                    document.getElementById('leaderboard').style.visibility='hidden';
                    if(up.length != 0 || down.length != 0) {
                        animate();
                        agents.forEach(function(agent){
                            agent.position = agent.position;
                        });
                    } else {
                        document.getElementById('loader').style.visibility='hidden';
                        document.getElementById('leaderboard').style.visibility='visible';
                    }
                });
                up = [];
                down = [];
                
            }

            function getPosition(id1,id2,up) {
                let agente1 = agents.find(agent => agent.id == id1);
                let position1 = agente1.position;
                let agente2 = agents.find(agent => agent.id == id2);
                let position2 = agente2.position;

                var position = position2-(position1);
                agents.find(function(value,index) {
                    if(up==false) {
                        if(value.id==id1 && value.position!=value.new_position) {
                            value.position = position2;
                        }
                    } else {
                        if(value.id==id2 && value.position!=value.new_position) {
                            value.position = position1;
                        }
                    }
                });

                return position;
            }

            function animate() {
                TweenMax.set($('.leader>li'), {
                    autoAlpha: 0,
                    y: 20
                })
                /*drew.find('.number').css({
                    'color': green
                });*/

                    TweenMax.staggerTo($('.leader>li'), 0.6, {
                    autoAlpha: 1,
                    y: 0,
                    ease: Expo.easeOut

                    }, 0.075, swappem)

            }
        </script>
    </body>
</html>