<tr <?=isset($trParams) ? $trParams : ""?>>
    <td>
        <div class="trDiv">
            <button <?=isset($buttonParams) ? $buttonParams : ""?>>
                <?=isset($buttonText) ? $buttonText : ""?>
            </button>
            <div <?=isset($tdDivParams) ? $tdDivParams : ""?>>
                <?=isset($tdDivText) ? $tdDivText : ""?>
            </div>
        </div>
    </td>
</tr>

