<template>
    <div id="player" class="container position-absolute bottom-0 start-50 translate-middle-x">
        <div class="row justify-content-center text-center">
            <p class="h2" :class="{ 'text-secondary': game.isSplitTurn || game.isDealerTurn }">Player
                <span class="badge rounded-pill"
                      :class="
                      {
                          'text-bg-danger': game.playerBust(),
                          'text-bg-warning': game.playerBlackjack(),
                          'text-bg-light': !game.playerBust() && !game.playerBlackjack()
                      }">
                {{ game.getPlayerScore() }}</span></p>
            <p v-if="game.isSplit" :class="{ 'text-secondary': !game.isSplitTurn }" class="h2">Split
                <span class="badge rounded-pill"
                      :class="
                      {
                          'text-bg-danger': game.splitBust(),
                          'text-bg-warning': game.splitBlackjack(),
                          'text-bg-light': !game.splitBust() && !game.splitBlackjack()
                      }">
                {{ game.getSplitScore() }}</span></p>
        </div>
        <div v-if="game.getPlayerCards()" class="row justify-content-center">
            <card v-if="game.isSplitTurn" v-for="card in game.splitCards" :card="card"/>
            <card v-else v-for="card in game.getPlayerCards()" :card="card"/>
        </div>
        <div class="row justify-content-around display-4">
            {{ game.bet }}
        </div>
        <actionButtons/>
    </div>
</template>

<script>
import Card from "@/components/card.vue";
import ActionButtons from "@/components/actionButtons.vue";
import {gameStore} from "@/stores/game";

export default {
    name: "player",
    components: {ActionButtons, Card},
    setup() {
        const game = gameStore();
        return {
            game,
        }
    }
}
</script>

<style scoped>

</style>