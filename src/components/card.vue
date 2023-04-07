<template>
  <!-- playing card -->
    <div :class="{'text-bg-success card-back': card.isFlipped}" class="playing-card card col-5 border-primary m-3">
        <div v-if="card.isFlipped === false" :class="{ 'text-danger' : setColourRed() }" class="card-body">
            <h5 class="card-title h1">{{ card.rank }}</h5>
            <p class="card-text h2">{{ displaySuit() }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "card",
    props: {
        card: {
            suit: String,
            rank: String,
            isFlipped: Boolean,
        },
    },
    methods: {
        displaySuit() {
            switch (this.card.suit) {
                case 'hearts':
                    return '♥';
                case 'diamonds':
                    return '♦';
                case 'spades':
                    return '♠';
                case 'clubs':
                    return '♣';
            }
        },
        setColourRed() {
            return this.card.suit === 'hearts' || this.card.suit === 'diamonds';
        }
    }
}
</script>

<style scoped>
.playing-card {
    height: 190px;
    width: 130px;
}

.card-back {
    background: repeating-linear-gradient(
        45deg,
        #198754,
        #198754 10px,
        #006033 10px,
        #006033 20px
    );

}
</style>