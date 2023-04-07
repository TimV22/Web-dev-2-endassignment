<template>
    <div class="row m-5 justify-content-around align-items-end">
        <button :disabled="!game.buttonsEnabled || game.isSplit" @click="gameActions.doubleDown()" class="btn btn-outline-primary border-5 btn-lg col-2">
            Double Down
        </button>
        <button :disabled="!game.canSplit() || !game.buttonsEnabled" @click="gameActions.split()"
                class="btn btn-outline-primary border-5 btn-lg col-2">Split
        </button>
        <button :disabled="!game.buttonsEnabled" @click="gameActions.hit()" class="btn btn-outline-primary border-5 btn-lg col-2">Hit
        </button>
        <button :disabled="!game.buttonsEnabled" @click="gameActions.stand()" class="btn btn-outline-primary border-5 btn-lg col-2">
            Stand
        </button>
    </div>
</template>

<script>
import {gameActionsStore} from "@/stores/gameActions";
import {gameStore} from "@/stores/game";

export default {
    name: "actionButtons",
    setup() {
        const gameActions = gameActionsStore();
        const game = gameStore();
        return {
            gameActions,
            game,
        }
    }
}
</script>

<style scoped>

</style>