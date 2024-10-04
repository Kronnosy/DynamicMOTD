<?php

/**
 *    oooooooooo.                                                        o8o            ooo        ooooo   .oooooo.   ooooooooooooo oooooooooo.
 *    `888'   `Y8b                                                       `"'            `88.       .888'  d8P'  `Y8b  8'   888   `8 `888'   `Y8b
 *     888      888 oooo    ooo ooo. .oo.    .oooo.   ooo. .oo.  .oo.   oooo   .ooooo.   888b     d'888  888      888      888       888      888
 *     888      888  `88.  .8'  `888P"Y88b  `P  )88b  `888P"Y88bP"Y88b  `888  d88' `"Y8  8 Y88. .P  888  888      888      888       888      888
 *     888      888   `88..8'    888   888   .oP"888   888   888   888   888  888        8  `888'   888  888      888      888       888      888
 *     888     d88'    `888'     888   888  d8(  888   888   888   888   888  888   .o8  8    Y     888  `88b    d88'      888       888     d88'
 *    o888bood8P'       .8'     o888o o888o `Y888""8o o888o o888o o888o o888o `Y8bod8P' o8o        o888o  `Y8bood8P'      o888o     o888bood8P'
 *                  .o..P'
 *                  `Y8P'
 *
 *
 *    This plugin is open source, allowing you to modify and duplicate it as you wish.
 *    Feel free to customize it according to your needs and contribute to its development.
 *    Your feedback and improvements are always welcome!
 *
 *    @name DynamicMOTD
 *    @author Kronnosy
 *    @version 1.0.0
 */

namespace Kronnosy\DynamicMOTD;


use Kronnosy\DynamicMOTD\
{
    task\DynamicTask
};

use pocketmine\
{
    plugin\PluginBase as Base
};

class DynamicMOTD extends Base
{
    /**
     * @return void
     */
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();

        $enabled = $this->getConfig()->get("enabled", true);
        $delay = $this->getConfig()->get("delay", 100);
        $motds = $this->getConfig()->get("motds", []);

        if (!$enabled) {
            $this->getLogger()->info("DynamicMOTD is disabled.");
            return;
        }

        $isDelayValid = is_int($delay) && $delay > 0;

        if (!$isDelayValid) {
            $this->getLogger()->warning("Delay must be a positive integer.");
            return;
        }

        $this->getScheduler()->scheduleRepeatingTask(
            new DynamicTask(
                $this,
                $motds
            ),
            $delay
        );

        parent::onEnable();
    }
}
