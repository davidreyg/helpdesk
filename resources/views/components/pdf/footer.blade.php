<!DOCTYPE html>
<meta charset="utf-8">
<style>
    .pageFooter {
        -webkit-print-color-adjust: exact;
        font-family: system-ui;
        font-size: 8pt;
        width: 100%;
        /* display: flex; */
        /* justify-content: space-between; */
        /* align-items: center; */
        margin: 0 20px 0 20px;
        /* position: relative; */
        /* padding: 10px; */
        /* background-color: red; */

        /* Ajusta el color de fondo si es necesario */
    }

    .pageFooter * {
        font-weight: lighter;
        font-style: italic
    }
</style>
<div class="pageFooter">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <p>Página <span class="pageNumber"></span> de <span class="totalPages"></span></p>

                </td>
                <td style="text-align: center">
                    <p class="date"></p>
                </td>
                <td style="text-align: right">
                    <p>@davidreyg</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
