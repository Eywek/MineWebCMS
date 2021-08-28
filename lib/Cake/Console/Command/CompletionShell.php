<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP Project
 * @package       Cake.Console.Command
 * @since         CakePHP v 2.5
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppShell', 'Console/Command');

/**
 * Provide command completion shells such as bash.
 *
 * @package       Cake.Console.Command
 */
class CompletionShell extends AppShell
{

    /**
     * Contains tasks to load and instantiate
     *
     * @var array
     */
    public $tasks = ['Command'];

    /**
     * Echo no header by overriding the startup method
     *
     * @return void
     */
    public function startup()
    {
    }

    /**
     * Not called by the autocomplete shell - this is for curious users
     *
     * @return void
     */
    public function main()
    {
        return $this->out($this->getOptionParser()->help());
    }

    /**
     * Gets the option parser instance and configures it.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->description(
            __d('cake_console', 'Used by shells like bash to autocomplete command name, options and arguments')
        )->addSubcommand('commands', [
            'help' => __d('cake_console', 'Output a list of available commands'),
            'parser' => [
                'description' => __d('cake_console', 'List all availables'),
                'arguments' => [
                ]
            ]
        ])->addSubcommand('subcommands', [
            'help' => __d('cake_console', 'Output a list of available subcommands'),
            'parser' => [
                'description' => __d('cake_console', 'List subcommands for a command'),
                'arguments' => [
                    'command' => [
                        'help' => __d('cake_console', 'The command name'),
                        'required' => true,
                    ]
                ]
            ]
        ])->addSubcommand('options', [
            'help' => __d('cake_console', 'Output a list of available options'),
            'parser' => [
                'description' => __d('cake_console', 'List options'),
                'arguments' => [
                    'command' => [
                        'help' => __d('cake_console', 'The command name'),
                        'required' => false,
                    ]
                ]
            ]
        ])->epilog(
            __d('cake_console', 'This command is not intended to be called manually')
        );

        return $parser;
    }

    /**
     * list commands
     *
     * @return void
     */
    public function commands()
    {
        $options = $this->Command->commands();
        return $this->_output($options);
    }

    /**
     * Emit results as a string, space delimited
     *
     * @param array $options The options to output
     * @return void
     */
    protected function _output($options = [])
    {
        if ($options) {
            return $this->out(implode(' ', $options));
        }
    }

    /**
     * list options for the named command
     *
     * @return void
     */
    public function options()
    {
        $commandName = '';
        if (!empty($this->args[0])) {
            $commandName = $this->args[0];
        }
        $options = $this->Command->options($commandName);

        return $this->_output($options);
    }

    /**
     * list subcommands for the named command
     *
     * @return void
     */
    public function subCommands()
    {
        if (!$this->args) {
            return $this->_output();
        }

        $options = $this->Command->subCommands($this->args[0]);
        return $this->_output($options);
    }

    /**
     * Guess autocomplete from the whole argument string
     *
     * @return void
     */
    public function fuzzy()
    {
        return $this->_output();
    }
}