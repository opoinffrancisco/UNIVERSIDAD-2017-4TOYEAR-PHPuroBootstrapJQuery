var globalIp = "";
var ipCLiente = function () {
    


    //obtiene la direccion IP:
    var obtener = function (callback){

        var ip_dups = {};
    
        //compatibilidad exclusiva de firefox y chrome, el usuario @guzgarcia compartio este enlace muy util: http://iswebrtcreadyyet.com/
        var RTCPeerConnection = window.RTCPeerConnection
            || window.mozRTCPeerConnection
            || window.webkitRTCPeerConnection;
        var useWebKit = !!window.webkitRTCPeerConnection;
    
        //bypass naive webrtc blocking using an iframe
        if(!RTCPeerConnection){
            //NOTE: necesitas tener un iframe in la pagina, exactamente arriba de la etiqueta script
            //
            //<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
            //<script>... se llama a la funcion getIPs aqui...
            //
            var win = iframe.contentWindow;
            RTCPeerConnection = win.RTCPeerConnection
                || win.mozRTCPeerConnection
                || win.webkitRTCPeerConnection;
            useWebKit = !!win.webkitRTCPeerConnection;
        }
    
        //requisitos minimos para conexion de datos
        var mediaConstraints = {
            optional: [{RtpDataChannels: true}]
        };
    
        var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};
    
        //construccion de una nueva RTCPeerConnection
        var pc = new RTCPeerConnection(servers, mediaConstraints);
    
        function handleCandidate(candidate){
            // coincidimos con la direccion IP
            var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
            var ip_addr = ip_regex.exec(candidate)[1];
    
            //eliminamos duplicados
            if(ip_dups[ip_addr] === undefined)
                callback(ip_addr);
    
            ip_dups[ip_addr] = true;
        }
    
        //escuchamos eventos candidatos
        pc.onicecandidate = function(ice){
    
            //dejamos de lado a los eventos que no son candidatos
            if(ice.candidate)
                handleCandidate(ice.candidate.candidate);
        };
    
        //creamos el canal de datos
        pc.createDataChannel("");
    
        //creamos un offer sdp
        pc.createOffer(function(result){
    
            //disparamos la peticion (request) al stun server (para entender mejor debemos ver la documentacion de WebRTC.
            pc.setLocalDescription(result, function(){}, function(){});
    
        }, function(){});
    
        //esperamos un rato para dejar que todo se complete:
        setTimeout(function(){
            //leemos la informacion del candidato desde la descripcion local
            var lines = pc.localDescription.sdp.split('\n');
    
            lines.forEach(function(line){
                if(line.indexOf('a=candidate:') === 0)
                    handleCandidate(line);
            });
        }, 1000);
    }
    

    return{
        Iniciar:function () {
          
            ipCLiente.obtenerPublic(function(ip){  
                globalIp = ip;
                sessionStorage.setItem("ip_cliente-US", globalIp);                
                console.log(sessionStorage.getItem("ip_cliente-US"));                
            });

        },
        obtenerPublic : obtener,
    }
}();

