let resource_tiles = Array.from(document.querySelectorAll(".coverflow-item"));

document.addEventListener("touchstart", swipe_start);

function swipe_start(event) {
    for(const tile of resource_tiles) {
        tile.style.transition = "linear 0s";
    }

    const initial_x = event.clientX ?? event.touches[0].clientX;
    let moving_item = null;
            
    for(const tile of resource_tiles) {
        if(tile.style.opacity == "1") {
            moving_item = tile;
            break;
        }
    }

    document.addEventListener("touchmove", swipe_move);

    function swipe_move(event) {
        const current_x = event.clientX ?? event.changedTouches[0].clientX;
        const x_delta = current_x-initial_x;

        moving_item.style.transform = "translate(calc(" + x_delta + "px - 50%), -50%)";
    }

    document.addEventListener("touchend", swipe_end);

    function swipe_end(event) {
        const current_x = event.clientX ?? event.changedTouches[0].clientX;
        const x_delta = current_x-initial_x;

        if(Math.abs(x_delta) > 80) {
            for(const tile of resource_tiles) {
                tile.style.transition = "ease-in 0.2s";
            }
            
            order_resources(-Math.sign(x_delta));
        } else {
            moving_item.style.transform = "translate(calc(0vw - 50%), -50%)";
        }

        document.removeEventListener("mousemove", swipe_move);
        document.removeEventListener("touchmove", swipe_move);
        document.removeEventListener("mouseup", swipe_end);
        document.removeEventListener("touchend", swipe_end);
    }
}

function order_resources(shift) {
    if(shift == -1) {
        resource_tiles.push(resource_tiles.shift());
    } else if(shift == 1) {
        resource_tiles.unshift(resource_tiles.pop());
    }

    for(let i = 0; i < resource_tiles.length; i++) {
        let t = (Math.round(resource_tiles.length/2-i))*100;
        
        if(t == 0) {
            resource_tiles[i].style.opacity = "1";
        } else {
            resource_tiles[i].style.opacity = "0";
        }

        resource_tiles[i].style.transform = "translate(calc("+t+"vw - 50%), -50%)";
    }
}

order_resources();