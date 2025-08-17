<?php

declare(strict_types=1);

namespace Falcon\Rendering;

use Latte\Engine;

class Renderer
{
    private(set) string $view;

    public function __construct(
        private Engine $latteEngine
    ) {
    }

    public function view(string $viewFilePath): self
    {
        if (!file_exists($viewFilePath)) {
            throw new \RuntimeException(sprintf('View file "%s" does not exist.', $viewFilePath));
        }

        $this->view = $viewFilePath;

        return $this;
    }

    public function render(): void
    {
        $this->latteEngine->render(
            !str_contains($this->view, '.latte') ?
                $this->view . '.latte' :
                $this->view
        );
    }
}
