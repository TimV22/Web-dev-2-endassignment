import {defineStore} from "pinia";
import {gameStore} from "./game";

export const gameActionsStore = defineStore("gameActions", {
    actions: {
        async doubleDown() {
            const game = gameStore();
            game.buttonsEnabled = false;
            game.bet *= 2;
            await this.hit();
            if (game.playerBust()) {
                await game.gameEnd()
                return;
            }
            await this.stand();
        },
        split() {
            const game = gameStore();
            game.splitCards.push(game.playerCards.pop());
            game.isSplitTurn = true;
            game.buttonsEnabled = true;
            game.isSplit = true;
            game.bet *= 2;

            //add cards
            game.playerCards.push(game.drawCard(false));
            game.splitCards.push(game.drawCard(false));

            //check for blackjack
            if (game.splitBlackjack()) {
                game.sleep(1000).then(() => {
                    this.stand();
                });
            }
        },
        async hit() {
            const game = gameStore();
            if (game.isSplitTurn) {
                game.splitCards.push(game.drawCard(false));
                if (game.splitBust() || game.splitBlackjack()) {
                    this.stand();
                }
                return;
            }
            game.playerCards.push(game.drawCard(false));

            if (game.playerBust() && !game.isDealerTurn) {
                await game.gameEnd();
                return;
            }

            if (game.playerBlackjack()) {
                await game.dealersTurn();
            }
        },
        async stand() {
            const game = gameStore();
            if (game.isSplitTurn) {
                game.isSplitTurn = false;
                if (game.playerBlackjack()) {
                    await game.sleep(250);
                    await game.dealersTurn();
                }
                return;
            }
            await game.dealersTurn();
        },
    }
});