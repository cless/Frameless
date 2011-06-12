<html>
    <body>
        <p>
            {if isset($form_error.g)}
            {$form_error.g}
            {/if}
        </p>
        <form name="wtf" action="/formexample/test/" method="post">
            {* Show the input field, but give it a default value only if a value is passed AND no error is passed *}
            <input type="text" name="a" {if isset($form_values.a) && !isset($form_error.a)}value="{$form_values.a}" {/if}/>
            {if isset($form_error.a)}<i>{$form_error.a}</i>{/if}<br>
            
            <input type="text" name="b" {if isset($form_values.b) && !isset($form_error.b)}value="{$form_values.b}" {/if}/>
            {if isset($form_error.b)}<i>{$form_error.b}</i>{/if}<br>
            
            <input type="text" name="c" {if isset($form_values.c) && !isset($form_error.c)}value="{$form_values.c}" {/if}/>
            {if isset($form_error.c)}<i>{$form_error.c}</i>{/if}<br>
            
            <input type="text" name="d" {if isset($form_values.d) && !isset($form_error.d)}value="{$form_values.d}" {/if}/>
            {if isset($form_error.d)}<i>{$form_error.d}</i>{/if}<br>

            <input type="text" name="e" {if isset($form_values.e) && !isset($form_error.e)}value="{$form_values.e}" {/if}/>
            {if isset($form_error.e)}<i>{$form_error.e}</i>{/if}<br>

            <input type="text" name="f" {if isset($form_values.f) && !isset($form_error.f)}value="{$form_values.f}" {/if}/>
            {if isset($form_error.f)}<i>{$form_error.f}</i>{/if}<br>
            
            <input type="hidden" name="g" value="{$token}" />

            <input type="submit" name="submit" />
        </form>
    </body>
</html>
