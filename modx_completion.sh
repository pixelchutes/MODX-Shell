#!/bin/bash
#
# bash completion support for symfony2 console
#
# Copyright (C) 2011 Matthieu Bontemps <matthieu@knplabs.com>
# Distributed under the GNU General Public License, version 2.0.

_console()
{
    local cur prev script
    COMPREPLY=()
    cur="${COMP_WORDS[COMP_CWORD]}"
    prev="${COMP_WORDS[COMP_CWORD-1]}"
    script="${COMP_WORDS[0]}"
    # Define site so we can grab command savailable for the instance
    site=""
    for var in "$@"
    do
#        if [[ $var == "-s" ]]; then
#            #echo "Looking for instances names"
#            names=$(${script} config:list | sed 's/|/ /' | awk '{print $1}')
#            echo $names;
#            return 0;
#            COMPREPLY=($(compgen -W "${commands}" -- ${cur}))
#            return  0;
#        fi
        if [[ $var == "-s"* ]] || [[ $var == "--site"* ]]; then
            site="$var"
        fi
    done

    if [[ ${cur} == -* ]] ; then
        # Get options
        PHP=$(cat <<'HEREDOC'
array_shift($argv);
$script = array_shift($argv);
$command = '';
foreach ($argv as $v) {
    if (0 !== strpos($v, '-')) {
        $command = $v;
        break;
    }
}

$xmlHelp = shell_exec($script.' help --xml ' . $command);
$options = array();
if (!$xml = @simplexml_load_string($xmlHelp)) {
    exit(0);
}
foreach ($xml->xpath('/command/options/option') as $option) {
    $options[] = (string) $option['name'];
}

echo implode(' ', $options);
HEREDOC
)

        args=$(printf "%s " "${COMP_WORDS[@]}")
        options=$($(which php) -r "$PHP" ${args});
        COMPREPLY=($(compgen -W "${options}" -- ${cur}))

        return 0
    fi

    commands=$(${script} list --raw "${site}" | sed -E 's/(([^ ]+ )).*/\1/')
    COMPREPLY=($(compgen -W "${commands}" -- ${cur}))

    return 0;
}

complete -F _console modx
COMP_WORDBREAKS=${COMP_WORDBREAKS//:}
