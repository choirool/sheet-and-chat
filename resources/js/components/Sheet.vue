<template>
  <hot-table :settings="settings" v-if="settings" ref="hotTableSheet"></hot-table>
</template>

<script>
import { HotTable } from '@handsontable/vue';
import Handsontable from 'handsontable'

export default {
    components: {
        HotTable
    },
    created() {
        this.setSheetSettings()
        this.laravelEcho()

        setTimeout(() => {
            this.$refs.hotTableSheet.hotInstance.selectCell(0, 0)
        })
    },
    data(){
        return {
            laravelEchoObj: null,
            settings: null,
        };
    },
    methods: {
        setSheetSettings() {
            this.settings = {
                data: sheetData,
                colHeaders: true,
                rowHeaders: true,
                minCols: 5,
                minRows: 5,
                afterChange: (change, source) => {
                    this.afterChangeEvent(change, source)
                },
                afterSelection: (x, y) => {
                    Echo.join(sheetChannel).whisper('position', {x,y})
                }
            }
        },
        laravelEcho() {
            Echo.join(sheetChannel)
                .listenForWhisper('position', (e) => {
                    this.setPosition(e.x, e.y)
                })
                .listen('SheetUpdated', (event) => {
                    this.settings.data = event.sheet.content
                })
        },
        afterChangeEvent(change, source) {
            if (source === 'loadData') return;
            console.log(change)

            fetch(fetchUrl, {
                method: 'PUT',
                body: JSON.stringify({ change: change[0], chages: change }),
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
        },
        setPosition(x, y) {
            this.$refs.hotTableSheet.hotInstance.updateSettings({
                customBorders: [{
                    row: x,
                    col: y,
                    left: {
                        width: 1,
                        color: 'blue'
                    },
                    right: {
                        width: 1,
                        color: 'blue'
                    },
                    top: {
                        width: 1,
                        color: 'blue'
                    },
                    bottom: {
                        width: 1,
                        color: 'blue'
                    }
                }]
            })
        }
    }
}
</script>