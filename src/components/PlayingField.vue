<template>
    <dealer/>
    <player/>
    <EndMessage v-if="game.showEndMessage"/>
</template>

<script>
import EndMessage from "@/components/EndMessage.vue";
import { gameStore } from "@/stores/game";
import Dealer from "@/components/dealer.vue";
import Player from "@/components/player.vue";

export default {
    name: "PlayingField",
    components: {Player, Dealer, EndMessage},
    mounted() {
        this.game.startGame();
    },
    setup() {
        const game = gameStore()
        return {
            game,
        }
    }
}
</script>

<style scoped>

</style>