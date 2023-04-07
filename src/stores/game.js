import {defineStore} from "pinia";
import {scoreCounterStore} from "@/stores/scoreCounter";

export const gameStore = defineStore("game", {
    state: () => ({
        deck: [],
        playerCards: [],
        dealerCards: [],
        splitCards: [],
        isDealerTurn: false,
        isSplitTurn: false,
        bet: 1,
        buttonsEnabled: true,
        showEndMessage: false,
        endMessage: "",
        isSplit: false,
        restartAllowed: false,
    }),
    actions: {
        getPlayerCards() {
            return this.playerCards;
        },
        getDealerCards() {
            return this.dealerCards;
        },
        getSplitScore() {
            return this.getScoreTotal(this.splitCards);
        },
        playerBlackjack() {
            return this.getScoreTotal(this.getPlayerCards()) === 21
        },
        dealerBlackjack() {
            return this.getScoreTotal(this.getDealerCards()) === 21
        },
        playerBust() {
            return this.getScoreTotal(this.playerCards) > 21
        },
        getPlayerScore() {
            return this.getScoreTotal(this.playerCards);
        },
        getDealerScore() {
            return this.getScoreTotal(this.dealerCards);
        },
        getScoreTotal(cards) {
            let total = 0;
            for (const card of cards) {
                if (card.rank === 'A') {
                    total += 11;
                } else if (card.rank === 'J' || card.rank === 'Q' || card.rank === 'K') {
                    total += 10;
                } else {
                    total += parseInt(card.rank);
                }
            }
            //if total is over 21, and there is an ace, make it worth 1 instead of 11
            if (total > 21) {
                for (const card of cards) {
                    if (card.rank === 'A') {
                        total -= 10;
                    }
                }
            }
            return total;
        },
        dealerBust() {
            return this.getScoreTotal(this.dealerCards) > 21
        },
        splitBust() {
            return this.getScoreTotal(this.splitCards) > 21
        },
        splitBlackjack() {
            return this.getScoreTotal(this.splitCards) === 21
        },
        makeDeck() {
            const suits = ['hearts', 'diamonds', 'spades', 'clubs'];
            const ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

            //for each type of suit and rank, make a card
            for (const element of suits) {
                for (const rank of ranks) {
                    let card = {};
                    card.suit = element;
                    card.rank = rank;
                    card.isFlipped = false;
                    this.deck.push(card);
                }
            }
        },
        drawCard(flipped) {
            const rnd = Math.floor(Math.random() * this.deck.length);
            const card = this.deck[rnd];
            this.deck.splice(rnd, 1);
            if (flipped) {
                card.isFlipped = true;
            }
            return card;
        },
        canSplit() {
            return (this.playerCards.length === 2 && this.playerCards[0].rank === this.playerCards[1].rank) && !this.isSplitTurn;
        },
        resetGame() {
            this.deck = [];
            this.playerCards = [];
            this.dealerCards = [];
            this.splitCards = [];
            this.isDealerTurn = false;
            this.isSplitTurn = false;
            this.buttonsEnabled = true
            this.showEndMessage = false;
            this.endMessage = "";
            this.bet = 1;
            this.isSplit = false;
            this.restartAllowed = false;
        },
        async startGame() {
            this.resetGame();
            this.makeDeck();
            this.playerCards.push(this.drawCard(false));
            this.playerCards.push(this.drawCard(false));
            this.dealerCards.push(this.drawCard(true));
            this.dealerCards.push(this.drawCard(false));
            if (this.playerBlackjack() || this.dealerBlackjack()) {
                this.dealerCards[0].isFlipped = false;
                this.isDealerTurn = true;
                await this.gameEnd();
            }
        },
        async dealersTurn() {
            await this.sleep(250);
            this.isDealerTurn = true;
            this.dealerCards[0].isFlipped = false;
            while (this.getScoreTotal(this.dealerCards) < 17) {
                await this.sleep(500);
                this.dealerCards.push(this.drawCard(false));
            }
            await this.gameEnd();
        },

        sleep(milliseconds) {
            return new Promise(resolve => setTimeout(resolve, milliseconds));
        },
        async gameEnd() {
            if (this.showEndMessage) {
                return;
            }
            const scoreCounter = scoreCounterStore();
            
            this.buttonsEnabled = false;
            await this.sleep(750);
            if (this.isSplit) {
                this.splitGameEnd();
                return;
            }

            if (this.playerWin()) {
                this.endMessage = "You win!";
                scoreCounter.add(this.bet);
            } else if (this.dealerWin()) {
                this.endMessage = "You lose!";
                scoreCounter.subtract(this.bet);
            }
            else {
                this.endMessage = "Draw!";
            }

            this.showEndMessage = true;
            this.restartAllowed = false;
            this.sleep(1000).then(() => {
                this.restartAllowed = true;
            });
        },
        playerWin() {
            return (this.getPlayerScore() > this.getDealerScore() && !this.playerBust()) || (this.dealerBust() && !this.playerBust()) || (this.playerBlackjack() && !this.dealerBlackjack());
        },
        dealerWin() {
            return (this.getDealerScore() > this.getPlayerScore() && !this.dealerBust()) || (this.playerBust() && !this.dealerBust()) || (this.dealerBlackjack() && !this.playerBlackjack());
        },
        splitWin() {
            return (this.getSplitScore() > this.getDealerScore() && !this.splitBust()) || (this.dealerBust() && !this.splitBust()) || (this.splitBlackjack() && !this.dealerBlackjack());
        },
        splitLose() {
            return (this.getDealerScore() > this.getSplitScore() && !this.dealerBust()) || (this.splitBust() && !this.dealerBust()) || (this.dealerBlackjack() && !this.splitBlackjack());
        },
        splitGameEnd() {
            const scoreCounter = scoreCounterStore();
            if (this.splitWin() && this.playerWin()) {
                this.endMessage = "You win! 2x";
                scoreCounter.add(this.bet);
            } else if (this.splitWin() || this.playerWin()) {
                this.endMessage = "You Win!";
                scoreCounter.subtract(this.bet);
            } else if (this.splitLose() && this.dealerWin()) {
                this.endMessage = "You lose! 2x";
                scoreCounter.subtract(this.bet);
            } else if (this.splitLose()) {
                this.endMessage = "You lose!";
                scoreCounter.add(this.bet);
            }
            else {
                this.endMessage = "Draw!";
            }
            this.showEndMessage = true;
            this.restartAllowed = false;
            this.sleep(1000).then(() => {
                this.restartAllowed = true;
            });
        }
    }
});