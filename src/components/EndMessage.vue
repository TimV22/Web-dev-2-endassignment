<template>
    <div class="container position-absolute top-50 start-50 translate-middle border border-4 border-primary-subtle rounded-5 bg-dark p-5 text-center">
        <div class="row justify-content-around">
            <h1>{{ game.endMessage }}</h1>
            <!-- enable button after 2 seconds -->
            <button @click="game.startGame()" :disabled="!game.restartAllowed" class="btn btn-secondary btn-lg mt-3">Restart</button>
        </div>
    </div>
</template>

<script>
import { gameStore } from "@/stores/game";

export default {
    name: "EndMessage",
    setup() {
        const game = gameStore();
        return {
            game
        }
    },
}
</script>

<style scoped>

</style>