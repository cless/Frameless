<html>
    <head>
        <title>MVC test!</title>
    </head>
    <body>
        {foreach $pagination as $item}
            {if not $item.active}<a href="{$item.link}">{/if}{$item.page}{if not $item.active}</a>{/if}
        {/foreach}
        <br />
        {if isset($member)}
        <a href="/members/list/">Back to memberlist</a>
        <table>
            <tr>
                <th>Name</th>
                <td>{$member.name}</td>
            </tr>
            <tr>
                <th>Site</th>
                <td>{$member.site}</td>
            </tr>
            <tr>
                <th>Language</th>
                <td>{$member.lang}</td>
            </tr>
        </table>
        {elseif isset($list)}
        <table>
            <tr>
                <th>Name</th>
                <th>Site</th>
                <th>Language</th>
            </tr>
            {foreach $list as $member}
            <tr>
                <td><a href="/members/user/{$member.name}">{$member.name}</a></td>
                <td>{$member.site}</td>
                <td>{$member.lang}</td>
            </tr>
            {/foreach}
        <table>
        {/if}
    </body>
</html>
