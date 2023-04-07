<template>
    <div class="container mt-5">
        <div id="dealer" v-if="game.getDealerCards()" class="row justify-content-center">
            <card v-for="card in game.getDealerCards()" :card="card"/>
        </div>
        <div class="row justify-content-center text-center">
            <p class="h2" :class="{ 'text-secondary': !game.isDealerTurn }">Dealer
                <span v-if="game.isDealerTurn" class="badge rounded-pill"
                      :class="
                      {
                          'text-bg-danger': game.dealerBust(),
                          'text-bg-warning': game.dealerBlackjack(),
                          'text-bg-light': !game.dealerBust() && !game.dealerBlackjack()
                      }">
                {{ game.getDealerScore() }}</span></p>
        </div>
    </div>
</template>

<script>
import {gameStore} from "@/stores/game";
import Card from "@/components/card.vue";

export default {
    name: "dealer",
    components: {Card},
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