<!DOCTYPE html>
<meta charset="utf-8">
<style>
    .pageHeader {
        -webkit-print-color-adjust: exact;
        font-family: system-ui;
        font-size: 6pt;
        width: 100%;
        /* display: flex; */
        /* justify-content: space-between; */
        /* align-items: center; */
        margin: 0 5px 0 5px;
        /* position: relative; */
        /* padding: 10px; */
        /* background-color: red; */

        /* Ajusta el color de fondo si es necesario */
    }

    .logo {
        height: 50px;
        /* Ajusta el tamaño del logo según sea necesario */
    }

    .header-item {
        display: flex;
        align-items: center;
    }
</style>
<header class="pageHeader">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <div class="header-item">
                        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
                    </div>
                </td>
                <td style="width: 350px">
                </td>
                <td class="text-left">
                    <span style="font-size: 15px"> DIRIS SEDE ADMINISTRATIVA</span>
                </td>
            </tr>
        </tbody>
    </table>
</header>
