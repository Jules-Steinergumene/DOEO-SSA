export enum DangerLevelEnum {
  LOW = 'Faible',
  MEDIUM = 'Moyen',
  HIGH = 'Haut',
  CRITICAL = 'Critique'
}

export namespace DangerLevelEnum {
  export function priority(level: DangerLevelEnum): number {
    switch (level) {
      case DangerLevelEnum.LOW:
        return 1;
      case DangerLevelEnum.MEDIUM:
        return 2;
      case DangerLevelEnum.HIGH:
        return 3;
      case DangerLevelEnum.CRITICAL:
        return 4;
      default:
        return 0;
    }
  }

  export function max(a: DangerLevelEnum, b: DangerLevelEnum): DangerLevelEnum {
    return priority(a) >= priority(b) ? a : b;
  }
}
